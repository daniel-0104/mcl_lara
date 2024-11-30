<?php

namespace App\Http\Controllers;

use App\Models\plan;
use App\Models\order;
use App\Models\message;
use App\Models\clientPer;
use App\Models\starterPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StarterPlanController extends Controller
{
    //starter plan add
    public function startPlanAdd(){
        $orderCounts = order::where('status','0')->get();
        $categories = plan::get();
        $permissions = clientPer::get();
        return view('main.admin.start-plan.add',compact('orderCounts','categories','permissions'));
    }

    //starter plan create
    public function startPlanCreate(Request $request){
        $data = $this->getStarterData($request);
        $this->starterValidationCheck($request);
        starterPlan::create($data);
        return redirect()->route('start#planList')->with(['success'=>'The starter package plan was created successfully.']);
    }

    //starter plan list
    public function startPlanList(){
        $orderCounts = order::where('status','0')->get();
        $projectPlans = starterPlan::selectRaw('MAX(id) as id, project_permission')
                                ->groupBy('project_permission')
                                ->orderBy('id', 'desc')
                                ->get();
        $permissionCounts = starterPlan::select('project_permission', DB::raw('COUNT(*) as count'))
                                    ->groupBy('project_permission')
                                    ->get()
                                    ->keyBy('project_permission');
        return view('main.admin.start-plan.list',compact('orderCounts','permissionCounts','projectPlans'));
    }

    //starter plan view
    public function startPlanView($permission){
        $orderCounts = order::where('status','0')->get();
        $plans = starterPlan::where('project_permission', $permission)->get();
        return view('main.admin.start-plan.view',compact('orderCounts','plans','permission'));
    }

    //starter plan edit
    public function startPlanEdit($id,Request $request){
        $orderCounts = order::where('status','0')->get();
        $plans = starterPlan::where('id',$id)->first();
        $categories = plan::get();
        $permissions = clientPer::get();
        return view('main.admin.start-plan.edit',compact('orderCounts','plans','categories','permissions'));
    }

    //starter plan update
    public function startPlanUpdate(Request $request){
        $data = $this->getStarterData($request);
        $this->starterValidationCheck($request);
        $plan = starterPlan::findOrFail($request->startPlanId);
        $plan->update($data);
        return redirect()->route('start#planView', ['permission' => $plan->project_permission])->with(['updateSuccess'=>'The starter package plan was updated successfully.']);
    }

    //starter plan delete
    public function startPlanDelete($id){
        $plans = starterPlan::find($id);
        $plans->delete();
        return back()->with(['deleteSuccess'=>'The starter package plan was deleted successfully.']);
    }

    //plan permission delete
    public function startPlanPerDelete($projectPermission){
        starterPlan::where('project_permission', $projectPermission)->delete();
        return back()->with(['perDeleteSuccess'=>'The permisson of plans were deleted successfully.']);
    }

    //get starter plan data
    private function getStarterData($request){
        return [
            'title' => $request->startPlanTitle,
            'time' => $request->startPlanExpire,
            'project_permission' => $request->projectPermission,
            'starter_plan' => $request->startPlanDescription
        ];
    }

    //starter validation check
    private function starterValidationCheck($request){
        Validator::make($request->all(),[
            'startPlanTitle' => 'required',
            'startPlanExpire' => 'required',
            'projectPermission' => 'required',
            'startPlanDescription' => 'required',
        ])->validate();
    }
}
