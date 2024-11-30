<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\order;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
    //admin profile page
    public function profileView(){
        $orderCounts = order::where('status','0')->get();
        return view('main.admin.profile.view',compact('orderCounts'));
    }

    //admin profile update
    public function profileUpdate($id, Request $request){
        $data = $this->getAdminData($request);
        $this->adminValidationCheck($request);
        User::where('id',$id)->update($data);
        return back()->with(['updateSuccess'=>'Your profile was updated successfully!']);
    }

    //admin password update
    public function passUpdate($id, Request $request){
        $this->passwordValidationCheck($request);

        $user = User::select('password')->where('id',$id)->first();
        $hashValue = $user->password;

        if(Hash::check($request->oldPassword, $hashValue)){
            $data = ['password' => Hash::make($request->newPassword)];
            User::where('id',$id)->update($data);
            return back()->with(['passUpdate'=>'Your password was updated successfully!']);
        }
        return back()->with(['passFail'=>'Your old password is not match.Try again!']);
    }


    //get admin data
    private function getAdminData($request){
        return [
            'name' => $request->name,
            'email' => $request->email
        ];
    }

    //admin validation check
    private function adminValidationCheck($request){
        $userId = Auth::check() ? Auth::user()->id : null;
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($userId),
            ]
        ])->validate();
    }

    //admin password validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6|max:30',
            'newPassword' => 'required|min:6|max:30',
            'confirmPassword' => 'required|min:6|max:30|same:newPassword'
        ])->validate();
    }



}
