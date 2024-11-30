<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\info;
use App\Models\plan;
use App\Models\team;
use App\Models\User;
use App\Models\order;
use App\Models\project;
use App\Models\orderList;
use App\Models\pricePlan;
use App\Models\clientLogo;
use App\Models\clientTesti;
use App\Models\starterPlan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    //user home page
    public function userHomePage(){
        $infos = info::first();
        $plans = pricePlan::get();
        $startPlans = starterPlan::get();
        $categories = plan::get();
        $clientLogos = clientLogo::get();
        $clientTestis = clientTesti::get();
        $projects = project::take(6)->get();
        $carts = [];
        if (Auth::check()) {
            $carts = cart::where('user_name', Auth::user()->name)->get();
        }
        return view('main.user.home',compact('infos','plans','startPlans','categories','clientLogos','clientTestis','projects','carts'));
    }

    //cases page
    public function userCaseList(){
        $infos = info::first();
        $projects = project::get();
        $carts = [];
        if (Auth::check()) {
            $carts = cart::where('user_name', Auth::user()->name)->get();
        }
        return view('main.user.cases.list',compact('infos','projects','carts'));
    }

    // cases type filter
    public function userCaseFilter($projectType){
        $infos = info::first();
        $projects = project::get();
        $typeProjects = project::where('type',$projectType)->get();
        $carts = [];
        if (Auth::check()) {
            $carts = cart::where('user_name', Auth::user()->name)->get();
        }
        return view('main.user.cases.list',compact('infos','projects','typeProjects','projectType','carts'));
    }

    // cases view
    public function userCaseView($id){
        $infos = info::first();
        $projects = project::where('id',$id)->first();
        $plans = pricePlan::where('project_permission', $projects->project_permission)->get();
        $startPlans = starterPlan::where('project_permission', $projects->project_permission)->get();
        $categories = plan::get();
        $carts = [];
        if (Auth::check()) {
            $carts = cart::where('user_name', Auth::user()->name)->get();
        }
        return view('main.user.cases.view',compact('infos','projects','plans','startPlans','categories','carts'));
    }


    //service page
    public function userServicePage(){
        $infos = info::first();
        $carts = [];
        if (Auth::check()) {
            $carts = cart::where('user_name', Auth::user()->name)->get();
        }
        return view('main.user.service',compact('infos','carts'));
    }

    //about page
    public function userAboutPage(){
        $teams = team::get();
        $infos = info::first();
        $carts = [];
        if (Auth::check()) {
            $carts = cart::where('user_name', Auth::user()->name)->get();
        }
        $clientLogos = clientLogo::get();
        return view('main.user.about',compact('teams','infos','carts','clientLogos'));
    }

    //contact page
    public function userContactPage(){
        $infos = info::first();
        $carts = [];
        if (Auth::check()) {
            $carts = cart::where('user_name', Auth::user()->name)->get();
        }
        return view('main.user.contact',compact('infos','carts'));
    }

    //profile
    public function userProfile(){
        $infos = info::first();
        $projects = project::where('project_permission', Auth::user()->project_permission)->first();
        $carts = [];
        if (Auth::check()) {
            $carts = cart::where('user_name', Auth::user()->name)->get();
        }

        $currentUserName = Auth::user()->name;
        $userCode = User::select('users.*', 'orders.order_code as user_order_code')
                        ->leftJoin('orders', 'orders.user_name', '=', 'users.name')
                        ->where('users.name', $currentUserName)
                        ->latest('orders.created_at')
                        ->first();

        if ($userCode) {
            $orderCounts = order::where('order_code', $userCode->user_order_code)->get();
            $orders = order::where('order_code', $userCode->user_order_code)->first();
            $orderLists = orderList::select('order_lists.*', 'orders.qty')
                                    ->join('orders', 'orders.order_code', '=', 'order_lists.order_code')
                                    ->where('order_lists.order_code', $userCode->user_order_code)
                                    ->get();
        }
        return view('main.user.account.profile',compact('infos','projects','carts','orderCounts','orders','orderLists'));
    }

    //profile update
    public function userPfpUpdate($id,Request $request){
        $data = $this->getuserData($request);
        $this->userValidationCheck($request);
        User::where('id',$id)->update($data);
        return back()->with(['updateSuccess'=>'Your profile was updated successfully!']);
    }

    //change password
    public function userChangePass(){
        $infos = info::first();
        $carts = [];
        if (Auth::check()) {
            $carts = cart::where('user_name', Auth::user()->name)->get();
        }
        return view('main.user.account.change-pass',compact('infos','carts'));
    }

    //admin password update
    public function userPassUpdate($id, Request $request){
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

    //cart list
    public function cartList()
    {
        $infos = info::first();
        $projects = project::where('project_permission', Auth::user()->project_permission)->first();
        $carts = [];
        $totalPrice = 0;
        $cashPrice = 0;

        if (Auth::check()) {
            $carts = cart::where('user_name', Auth::user()->name)->get();
            $totalPrice = $carts->sum('price');
            $cashPrice = $carts->sum('cash_back');
        }

        return view('main.user.cart', compact('infos','projects','carts', 'totalPrice','cashPrice'));
    }


    //get user data
    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email
        ];
    }

    //user validation check
    private function userValidationCheck($request){
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

    //password validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6|max:30',
            'newPassword' => 'required|min:6|max:30',
            'confirmPassword' => 'required|min:6|max:30|same:newPassword'
        ])->validate();
    }
}
