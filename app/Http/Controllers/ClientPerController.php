<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\message;
use App\Models\clientPer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientPerController extends Controller
{
    //permission list
    public function perList(){
        $orderCounts = order::where('status','0')->get();
        $permissions = clientPer::orderBy('id','desc')->paginate(30);
        return view('main.admin.category.permission.list',compact('orderCounts','permissions'));
    }

    //permission create
    public function perCreate(Request $request){
        $data = $this->getPermissionData($request);
        $this->permissionValidationCheck($request);
        clientPer::create($data);
        return back()->with(['success'=>'The permission was created successfully!']);
    }

    //permission edit
    public function perEdit($id){
        $orderCounts = order::where('status','0')->get();
        $permissions = clientPer::where('id', $id)->first();
        return view('main.admin.category.permission.edit',compact('permissions','orderCounts'));
    }

    //permission update
    public function perUpdate(Request $request){
        $data = $this->getPermissionData($request);
        $this->permissionValidationCheck($request);
        clientPer::where('id',$request->perId)->update($data);
        return redirect()->route('per#list')->with(['update'=>'The permission was updated successfully!']);
    }

    //permission delete
    public function perDelete($id, Request $request){
        $data = $this->getPermissionData($request);
        clientPer::where('id',$id)->delete($data);
        return back()->with(['deleteSuccess'=>'The permission was deleted successfully!']);
    }

    //get permission data
    private function getPermissionData($request){
        return [
            'name' => $request->permissionName
        ];
    }

    //permission validation check
    private function permissionValidationCheck($request){
        Validator::make($request->all(), [
            'permissionName' => 'required|unique:plans,name'
        ], [
            'permissionName.unique' => 'The permission name already exists. Please choose a different name.'
        ])->validate();
   }
}
