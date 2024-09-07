<?php

namespace App\Lib;

use App\Models\Transaction;
use App\Models\User;
use Exception;

class Matrix
{
    /**
    * User who purchase the plan
    *
    * @var object
    */
    private $user;


    /**
    * Plan which has purchased by the user
    *
    * @var object
    */
    private $plan;


    /**
    * Matrix height
    *
    * @var integer
    */
    private $height;


    /**
    * Matrix width
    *
    * @var integer
    */
    private $width;


    /**
    * All transactions data of this process
    *
    * @var array
    */
    private $transactions = [];


    /**
    * Transaction number of transactions
    *
    * @var array
    */
    private $trx;


    /**
    * Set the user and plan object to properties
    *
    * @param object $user
    * @param object $plan
    *
    * @return void
    */
    public function __construct($user,$plan)
    {
        $general = gs();
        $this->user = $user;
        $this->plan = $plan;
        $this->height = $general->matrix_height;
        $this->width = $general->matrix_width;
        $this->trx = getTrx();

        //throw exception
        $this->getException();
    }

    /**
     * Purchase user plan
     *
     * @return void;
     */
    public function planPurchase()
    {
        $user = $this->user;
        $plan = $this->plan;
        $user->plan_id = $plan->id;
        $user->save();

        $user->balance -= $plan->price;
        $user->save();

        //push to transactions
        $this->pushTransaction([
            'user_id'=>$user->id,
            'amount'=>$plan->price,
            'post_balance'=>$user->balance,
            'trx_type'=>'-',
            'details'=>$plan->name.' plan purchase',
            'remark'=>'plan_purchase'
        ]);

        $this->getPosition();
        $this->referralCommission();
        $this->levelCommission();
        $this->storeTransactions();

        notify($user, 'PLAN_PURCHASED', [
            'currency' => gs()->cur_text,
            'trx' => $this->trx,
            'price' => showAmount($plan->price),
            'plan_name' =>  $plan->name,
            'post_balance' => showAmount($user->balance),
        ]);
    }

    /**
     * Set the position of the user
     *
     * @return boolean;
     */
    public function getPosition()
    {
        if (!$this->user->ref_by){
            return false;
        }

        $user = $this->user;
        $referral = $this->user->referral;
        $isBreak = false;

        // Direct position
        $nextPosition = $this->nextPosition($referral->id);

        if($nextPosition){
            $user->position_id  = $referral->id;
            $user->position     = $nextPosition;
            $user->save();
            return true;
        }

        for ($level=1; $level < 100000 ; $level++) {

            $myref = $this->showPositionBelow($referral->id);

            $next =   $myref;
            for ($i=1; $i < $level ; $i++) {
                $next = array();
                foreach($myref as $uu){
                    $n = $this->showPositionBelow($uu);
                    $next = array_merge($next, $n);
                }
                $myref = $next;
            }

            foreach($next as $uu){
                $nextPosition = $this->nextPosition($uu);
                if($nextPosition){
                    $user->position_id = $uu;
                    $user->position = $nextPosition;
                    $user->save();
                    $isBreak = true;
                }
                if($isBreak){
                    break;
                }
            }
            if($isBreak){
                break;
            }
        }
    }

    /**
    * Get all immediate below users
    *
    * @param integer $id
    * @return array
    */
    private function showPositionBelow($id){
       return User::where('position_id',$id)->pluck('id')->toArray();
    }

    /**
    * Get the next position
    *
    * @param integer $id
    * @return integer
    */
    private function nextPosition($id){
        $count = User::where('position_id', $id)->count();

        if($count < $this->width){
            return $count+1;
        }
        return 0;
    }

    /**
    * Give direct referral commission to referrer
    *
    * @return void
    */
    public function referralCommission(){

        $user = $this->user;
        $referral = $user->referral;
        $plan = $this->plan;
        if ($referral) {
            $referral->balance += $plan->referral_bonus;
            $referral->save();

            //Push to transactions
            $this->pushTransaction([
                'user_id'=>$referral->id,
                'amount'=> showAmount($plan->referral_bonus),
                'post_balance'=> showAmount($referral->balance),
                'trx_type'=>'+',
                'remark'=>'referral_commission',
                'details'=>'Referral commission from '.$user->username,
            ]);

            notify($referral, 'REFERRAL_COMMISSION', [
                'amount' => showAmount($plan->referral_bonus),
                'username' => $user->username,
                'currency' => gs()->cur_text,
                'trx' => $this->trx,
                'post_balance' => showAmount($referral->balance),
            ]);
        }
    }

    /**
    * Give direct level commission to upper
    *
    * @return void
    */
    public function levelCommission(){

        $user = $this->user;

        $commissions = $this->plan->level;
        for ($i=0; $i < $this->height; $i++) {
            $commission = @$commissions[$i];
            if (!$commission) {
                break;
            }
            $upper = $user->upper;
            if (!$upper) {
                break;
            }
            $upper->balance += $commission->amount;
            $upper->save();

            //push to transactions
            $this->pushTransaction([
                'user_id'=>$upper->id,
                'amount'=>showAmount($commission->amount),
                'post_balance'=>showAmount($upper->balance),
                'trx_type'=>'+',
                'remark'=>'level_commission',
                'details'=>'Level '.($i+1).' commission from '.$user->username,
            ]);

            $user = $upper;
        }
    }

    /**
    * Push all transaction data to transactions
    *
    * @param array $data
    * @return void
    */
    private function pushTransaction($data){
        $transactions[] = [
            'user_id' => $data['user_id'],
            'amount' => $data['amount'],
            'post_balance' => $data['post_balance'],
            'charge' => 0,
            'trx_type' => $data['trx_type'],
            'details' => $data['details'],
            'remark' => @$data['remark'],
            'trx' => $this->trx,
            'created_at' => now(),
        ];
        $this->transactions = array_merge($this->transactions, $transactions);
    }

    /**
    * Store transactions to database
    *
    * @param array $data
    * @return void
    */
    public function storeTransactions(){
        $transactions = $this->transactions;
        Transaction::insert($transactions);
    }

    /**
    * All exception of this process
    *
    * @return void
    */
    private function getException(){
        if ($this->user->plan) {
            $message = 'You can\'t buy plan twice';
            $this->throwException($message);
        }

        if ($this->user->balance < $this->plan->price) {
            $message = 'You don\'t have sufficient balance';
            $this->throwException($message);
        }

        $referral = $this->user->referral;

        if($referral){
            if($referral->plan_id != $this->plan->id){
                $message = 'You have to purchase a plan which have purchased your referrer';
                $this->throwException($message);
            }
        }
    }

    /**
    * All exception will throw from here
    *
    * @return void
    */
    private function throwException($message){
        throw new Exception($message);
    }
}


