<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\Matrix;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class PlanController extends Controller
{

    public function plan()
    {
        $pageTitle = "Plan Subscribe";
        $plans = Plan::where('status', Status::ENABLE)->orderby('id', 'asc')->paginate(getPaginate());
        return view($this->activeTemplate . 'plan', compact('pageTitle', 'plans'));
    }

    public function planOrder($id)
    {

        $plan = Plan::with('level')->findOrFail($id);
        $user = User::with('referral')->find(auth()->id());

        try {
            $matrix = new Matrix($user, $plan);
        } catch (\Exception $exp) {
            $notify[] = ['error', $exp->getMessage()];
            return back()->withNotify($notify);
        }

        $matrix->planPurchase();
        $notify[] = ['success', 'The plan has been subscribed'];
        return back()->withNotify($notify);
    }
}
