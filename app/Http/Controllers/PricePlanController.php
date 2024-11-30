<?php

namespace App\Http\Controllers;

use App\Models\plan;
use App\Models\order;
use App\Models\message;
use App\Models\clientPer;
use App\Models\pricePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PricePlanController extends Controller
{
    //price plan add
    public function planAdd(){
        $orderCounts = order::where('status','0')->get();
        $categories = plan::get();
        $permissions = clientPer::get();
        return view('main.admin.price-plan.add',compact('orderCounts','categories','permissions'));
    }

    // price plan create
    public function planCreate(Request $request){
        $data = $this->getPlanData($request);
        $this->planValidationCheck($request);
        pricePlan::create($data);
        return redirect()->route('plan#list')->with(['success'=>'The package plan was created successfully.']);
    }

    //price plan list
    public function planList(Request $request){
        $orderCounts = order::where('status','0')->get();
        $projectPlans = pricePlan::selectRaw('MAX(id) as id, project_permission')
                                ->groupBy('project_permission')
                                ->orderBy('id', 'desc')
                                ->paginate(30);
        $permissionCounts = pricePlan::select('project_permission', DB::raw('COUNT(*) as count'))
                                    ->groupBy('project_permission')
                                    ->get()
                                    ->keyBy('project_permission');
        return view('main.admin.price-plan.list',compact('orderCounts','projectPlans','permissionCounts'));
    }

    //price plan view
    public function planView($permission){
        $orderCounts = order::where('status','0')->get();
        $plans = pricePlan::where('project_permission', $permission)->get();
        return view('main.admin.price-plan.view',compact('orderCounts','plans','permission'));
    }

    //price plan edit
    public function planEdit($id,Request $request){
        $orderCounts = order::where('status','0')->get();
        $plans = pricePlan::where('id',$id)->first();
        $categories = plan::get();
        $permissions = clientPer::get();
        return view('main.admin.price-plan.edit',compact('orderCounts','plans','categories','permissions'));
    }

    //price plan update
    public function planUpdate(Request $request){
        $data = $this->getPlanData($request);
        $this->planValidationCheck($request);
        $plan = pricePlan::findOrFail($request->planId);
        $plan->update($data);
        return redirect()->route('plan#view', ['permission' => $plan->project_permission])->with(['updateSuccess'=>'The package plan was updated successfully.']);
    }

    //price plan delete
    public function planDelete($id){
        $plans = pricePlan::find($id);
        $plans->delete();
        return back()->with(['deleteSuccess'=>'The package plan was deleted successfully.']);
    }

    //plan permission delete
    public function planPermissionDelete($projectPermission){
        pricePlan::where('project_permission', $projectPermission)->delete();
        return back()->with(['perDeleteSuccess'=>'The permisson of plans were deleted successfully.']);
    }

    //get plan data
    private function getPlanData($request){
        return [
            'title' => $request->planTitle,
            'price' => $request->planPrice,
            'time' => $request->planExpire,
            'project_permission' => $request->planPermission,
            'cash_back' => $request->cashBackPrice ?? 0,
            'description' => $request->planDescription
        ];
    }

    //plan validation check
    private function planValidationCheck($request){
        Validator::make($request->all(),[
            'planTitle' => 'required',
            'planPrice' => 'required',
            'planExpire' => 'required',
            'planPermission' => 'required',
            'planDescription' => 'required',
            'cashBackPrice' => 'nullable|integer|min:0'
        ])->validate();
    }
}
