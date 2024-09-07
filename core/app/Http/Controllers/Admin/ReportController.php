<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\NotificationLog;
use App\Models\Transaction;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaction(Request $request)
    {
        $pageTitle = 'Transaction Logs';

        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::searchable(['trx', 'user:username'])->filter(['trx_type', 'remark'])->dateFilter()->orderBy('id', 'desc')->with('user')->paginate(getPaginate());

        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function loginHistory(Request $request)
    {
        $pageTitle = 'User Login History';
        $loginLogs = UserLogin::orderBy('id', 'desc')->searchable(['user:username'])->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = UserLogin::where('user_ip', $ip)->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs', 'ip'));
    }

    public function notificationHistory(Request $request)
    {
        $pageTitle = 'Notification History';
        $logs = NotificationLog::orderBy('id', 'desc')->searchable(['user:username'])->with('user')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs'));
    }

    public function emailDetails($id)
    {
        $pageTitle = 'Email Details';
        $email = NotificationLog::findOrFail($id);
        return view('admin.reports.email_details', compact('pageTitle', 'email'));
    }

    public function commissions()
    {
        $pageTitle = 'Commissions Logs';
        $commissions = Commission::with('user', 'fromUser')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.commissions', compact('pageTitle', 'commissions'));
    }

    public function commissionsSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = 'Commissions Search - ' . $search;
        $commissions = Commission::with('user', 'fromUser')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like', "%$search%");
        })->orWhere('trx', $search)->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.commissions', compact('pageTitle', 'commissions', 'search'));
    }

    public function commissionSelect(Request $request)
    {
        $request->validate(['commissions' => 'required|in:1,2']);
        $commi = $request->commissions;
        if ($request->commissions == 1) {
            $pageTitle = "Referrals Commissions Log";
            $commissions = Commission::with('user', 'fromUser')->where('mark', 1)->orderBy('id', 'desc')->paginate(getPaginate());
        } elseif ($request->commissions == 2) {
            $pageTitle = "Level Commissions Log";
            $commissions = Commission::with('user', 'fromUser')->where('mark', 2)->orderBy('id', 'desc')->paginate(getPaginate());
        }
        return view('admin.reports.commissions', compact('pageTitle', 'commissions', 'commi'));
    }

    public function recharge()
    {
        $pageTitle = 'Recharge Logs';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::where('remark', 'epin')->searchable(['trx', 'user:username'])->filter(['trx_type'])->dateFilter()->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.recharges', compact('pageTitle', 'transactions', 'remarks'));
    }
}
