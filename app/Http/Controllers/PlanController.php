<?php

namespace App\Http\Controllers;

use App\Models\plan;
use App\Models\order;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    //category list
    public function categoryList(){
        $orderCounts = order::where('status','0')->get();
        $categories = plan::orderBy('id','desc')->paginate(15);

        return view('main.admin.category.price-plan.list',compact('orderCounts','categories'));
    }

    // category create
    public function categoryCreate(Request $request){
        $data = $this->getCategoryData($request);
        $this->categoryValidationCheck($request);
        plan::create($data);
        return back()->with(['success'=>'The plan was created successfully!']);
    }

    //category edit
    public function categoryEdit($id){
        $orderCounts = order::where('status','0')->get();
        $categories = plan::where('id', $id)->first();
        return view('main.admin.category.price-plan.edit',compact('categories','orderCounts'));
    }

    //category update
    public function categoryUpdate(Request $request){
        $data = $this->getCategoryData($request);
        $this->categoryValidationCheck($request);
        plan::where('id',$request->categoryId)->update($data);
        return redirect()->route('category#list')->with(['update'=>'The plan was updated successfully!']);
    }

    //category delete
    public function categoryDelete($id, Request $request){
        $data = $this->getCategoryData($request);
        plan::where('id',$id)->delete($data);
        return back()->with(['deleteSuccess'=>'The plan was deleted successfully!']);
    }

    // get category data
    private function getCategoryData($request){
        return [
            'name' => $request->categoryName
        ];
    }

    // category validation check
    private function categoryValidationCheck($request){
         Validator::make($request->all(), [
                'categoryName' => 'required|unique:plans,name'
            ], [
                'categoryName.unique' => 'The plan name already exists. Please choose a different name.'
            ])->validate();
    }
}
