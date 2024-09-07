<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\Commission;
use App\Models\Form;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        $user = auth()->user();
        $pageTitle = 'Dashboard';
        $deposit = $user->deposits()->sum('amount');
        $transactions = $user->transactions()->orderBy('id', 'desc')->limit(8)->get();
        $commission = Commission::where('user_id', $user->id)->sum('amount');
        $withdraw = Withdrawal::where('user_id', $user->id)->where('status', '!=', Status::PAYMENT_INITIATE)->sum('amount');
        $transaction = $user->transactions()->count();
        $username = $user->username;
        $balance = $user->balance;
        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'deposit', 'transactions', 'commission', 'withdraw', 'transaction', 'username', 'balance','user'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $general = gs();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate . 'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request)
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::where('user_id', auth()->id())->searchable(['trx'])->filter(['trx_type', 'remark'])->orderBy('id', 'desc')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == 2) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == 1) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act', 'kyc')->first();
        return view($this->activeTemplate . 'user.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        return view($this->activeTemplate . 'user.kyc.info', compact('pageTitle', 'user'));
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act', 'kyc')->first();
        $formData = $form->form_data;
        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);
        $user = auth()->user();
        $user->kyc_data = $userData;
        $user->kv = 2;
        $user->save();

        $notify[] = ['success', 'KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function attachmentDownload($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $user = auth()->user();
        if ($user->profile_complete == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate . 'user.user_data', compact('pageTitle', 'user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->profile_complete == 1) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'city' => $request->city,
        ];
        $user->profile_complete = 1;
        $user->save();

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function balanceTransfer()
    {
        $general = gs();
        if ($general->balance_transfer != 1) {
            $notify[] = ['warning', "Balance transfer doesn't available this time"];
            return redirect()->route('user.home')->withNotify($notify);
        }
        $pageTitle = "Balance Transfer";
        return view($this->activeTemplate . 'user.balance_transfer', compact('pageTitle'));
    }

    public function balanceTransferUser(Request $request)
    {
        $general = gs();
        if ($general->balance_transfer != 1) {
            $notify[] = ['warning', "Balance transfer doesn't available this time"];
            return redirect()->route('home')->withNotify($notify);;
        }
        $this->validate($request, [
            'amount' => 'required|numeric|gt:0',
            'username' => 'required'
        ]);
        $user = auth()->user();
        $toUser = User::where('status', Status::VERIFIED)->where('username', $request->username)->first();
        if (!$toUser) {
            $notify[] = ['error', 'Receiver not found'];
            return back()->withNotify($notify);
        }
        if ($user->id == $toUser->id) {
            $notify[] = ['error', "You can not transfer balance to self account."];
            return back()->withNotify($notify);
        }
        $charge = (($request->amount / 100) * $general->balance_transfer_percent_charge) + $general->balance_transfer_fixed_charge;
        $total = $request->amount + $charge;

        if ($total > $user->balance) {
            $notify[] = ['error', 'Your account balance ' . getAmount($user->balance) . ' ' . $general->cur_text . ' not enough for balance transfer'];
            return back()->withNotify($notify);
        }
        $user->balance -=  $total;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $total;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $charge;
        $transaction->trx_type = '-';
        $transaction->details = 'Balance Transferred To ' . $toUser->username;
        $transaction->remark = "balance_send";
        $transaction->trx = getTrx();
        $transaction->save();

        notify($user, 'BAL_TRANSFER_SENDER', [
            'trx' => $transaction->trx,
            'amount' => getAmount($request->amount),
            'charge' => getAmount($charge),
            'after_charge' => getAmount($total),
            'post_balance' => getAmount($user->balance),
        ]);

        $toUser->balance += $request->amount;
        $toUser->save();

        $tranUser = new Transaction();
        $tranUser->user_id = $toUser->id;
        $tranUser->amount = $request->amount;
        $tranUser->post_balance = $toUser->balance;
        $tranUser->trx_type = '+';
        $tranUser->details = 'Balance Transferred From ' . $user->username;
        $tranUser->trx = $transaction->trx;
        $tranUser->remark = "balance_receive";
        $tranUser->save();

        notify($toUser, 'BAL_TRANSFER_RECEIVER', [
            'trx' => $tranUser->trx,
            'amount' => getAmount($tranUser->amount),
            'post_balance' => getAmount($toUser->balance),
        ]);

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Balance Transferred To ' . $toUser->username;
        $adminNotification->click_url = urlPath('admin.report.transaction');
        $adminNotification->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Balance Transferred From ' . $user->username;
        $adminNotification->click_url = urlPath('admin.report.transaction');
        $adminNotification->save();

        $notify[] = ['success', 'Balance has been transfer'];
        return back()->withNotify($notify);
    }

    public function referralLog()
    {
        $pageTitle = 'My Referred Users';
        $user      = auth()->user();
        return view($this->activeTemplate . 'user.referral', compact('pageTitle', 'user'));
    }

    public function referralCommission()
    {
        $pageTitle = "My Referral Commissions";
        $commissions = Commission::where('user_id', auth()->id())->where('mark', 1)->with('fromUser')->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.commission', compact('pageTitle', 'commissions'));
    }

    public function levelCommission()
    {
        $pageTitle = "My Level Commissions";
        $commissions = Commission::where('user_id', auth()->id())->where('mark', 2)->with('fromUser')->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.commission', compact('pageTitle', 'commissions'));
    }

    private function showBelow($id)
    {
        $newArray = array();
        $underReferral = User::where('position_id', $id)->get();
        foreach ($underReferral as $value) {
            array_push($newArray, $value->id);
        }
        return $newArray;
    }
}
