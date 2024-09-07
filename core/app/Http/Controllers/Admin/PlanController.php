<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $pageTitle = "All Plan List";
        $plans = Plan::orderBy('id','asc')->with('level')->paginate(getPaginate());
        return view('admin.plan.index', compact('pageTitle', 'plans'));
    }

    public function create()
    {
        $pageTitle = "Plan Create";
        return view('admin.plan.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|gt:0',
            'referral_bonus' => 'required|numeric|gt:0',
            'level' => 'required|array',
            'level.*' => 'numeric|gt:0'
        ]);

        $plan = new Plan();
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->referral_bonus = $request->referral_bonus;
        $plan->save();

        $this->levelUpdate($request, $plan);

    	$notify[] = ['success', 'Plan added Successfully'];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
    	$plan = Plan::findOrFail($id);
    	$pageTitle = "Plan Update";
        $totalAmount = $plan->sumLevelOfCommission($plan->id) + $plan->referral_bonus;
        $finalAmount = $plan->price - $totalAmount;
    	return view('admin.plan.edit', compact('pageTitle', 'plan', 'totalAmount', 'finalAmount'));
    }

    public function update(Request $request, $id)
    {
    	$request->validate([
    	 	'name' => 'required',
    	 	'price' => 'required|numeric|gt:0',
    	 	'referral_bonus' => 'required|numeric|gt:0',
            'level' => 'required|array',
            'level.*' => 'numeric|gt:0'
    	]);
    	$plan = Plan::findOrFail($id);
    	$plan->name = $request->name;
    	$plan->price = $request->price;
    	$plan->referral_bonus = $request->referral_bonus;
    	$plan->save();

        $this->levelUpdate($request, $plan);

    	$notify[] = ['success', 'Plan updated successfully'];
    	return back()->withNotify($notify);
    }

    private function levelUpdate($request, $plan){

        $level = Level::where('plan_id', $plan->id)->delete();
        foreach($request->level as $l=>$a)
        {
            $level = new Level();
            $level->plan_id = $plan->id;
            $level->level = $l;
            $level->amount = $a;
            $level->save();
        }
    }

    public function status($id)
    {
        return Plan::changeStatus($id);
    }

    public function matrixSetting(Request $request)
    {
        $request->validate([
            'matrix_height' => 'required|integer|gt:0',
            'matrix_width' => 'required|integer|gt:0'
        ]);
        $general = gs();
        $general->matrix_height = $request->matrix_height;
        $general->matrix_width = $request->matrix_width;
        $general->save();
        $notify[] = ['success', 'Matrix setting has been updated'];
        return back()->withNotify($notify);
    }

}
