<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\order;
use App\Models\message;
use App\Models\clientPer;
use App\Models\clientLogo;
use App\Models\clientTesti;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class clientController extends Controller
{
    //client logo list
    public function logoList(){
        $orderCounts = order::where('status','0')->get();
        $clientLogos = clientLogo::orderBy('id','desc')->paginate(30);
        return view('main.admin.clients.logo.list',compact('orderCounts','clientLogos'));
    }

    // client logo create
    public function logoCreate(Request $request){
        $data = $this->getLogoData($request);
        $this->logoValidationCheck($request);

        $customText = 'clogo';
        $fileName = $customText.$request->file('clientLogo')->getClientOriginalName();
        $request->file('clientLogo')->storeAs('client-logo',$fileName,'public');
        $data['image'] = $fileName;

        clientLogo::create($data);
        return back()->with(['success'=>'The client logo was created successfully.']);
    }

    //client logo edit
    public function logoEdit($id){
        $orderCounts = order::where('status','0')->get();
        $clientLogos = clientLogo::where('id',$id)->first();
        return view('main.admin.clients.logo.edit',compact('orderCounts','clientLogos'));
    }

    //client logo update
    public function logoUpdate(Request $request){
        $data = $this->getLogoData($request);
        $this->logoValidationCheck($request);

        if($request->hasFile('clientLogo')){
            $oldImage = clientLogo::where('id',$request->clientLogoId)->value('image');
            $customText = 'clogo';
            $fileName = $customText.$request->file('clientLogo')->getClientOriginalName();
            $request->file('clientLogo')->storeAs('client-logo',$fileName,'public');
            $data['image'] = $fileName;

            if($oldImage != null){
                $oldImagePath = storage_path('app/public/client-logo/'.$oldImage);
                if(file_exists($oldImagePath)){
                    unlink($oldImagePath);
                }
            }

            clientLogo::where('id',$request->clientLogoId)->update($data);
            return redirect()->route('logo#list')->with(['updateSuccess'=>'The client logo was updated successfully!']);
        }
    }

    //client logo delete
    public function logoDelete($id){
        $clientLogos = clientLogo::find($id);
        $imagePath = public_path('storage/client-logo/'.$clientLogos->image);
        if(file_exists($imagePath)){
            unlink($imagePath);
        }
        $clientLogos->delete();
        return back()->with(['deleteSuccess'=>'The client logo was deleted successfully!']);
    }

    // get logo data
    private function getLogoData($request){
        return [
            'image' => $request->clientLogo
        ];
    }

    //logo validation check
    private function logoValidationCheck($request){
        Validator::make($request->all(),[
            'clientLogo' => 'required|mimes:png,jpg,jpeg,webp,avif|file'
        ])->validate();
    }



    //client reviews list
    public function reviewList(){
        $orderCounts = order::where('status','0')->get();
        $clientTestis = clientTesti::orderBy('id','desc')->paginate(30);
        return view('main.admin.clients.testi.list',compact('orderCounts','clientTestis'));
    }

    //review create
    public function reviewCreate(Request $request){
        $data = $this->getReviewData($request);
        $this->reviewValidationCheck($request);
        clientTesti::create($data);
        return back()->with(['success'=>'The client review was created successfully.']);
    }

    //review edit
    public function reviewEdit($id){
        $orderCounts = order::where('status','0')->get();
        $clientTestis = clientTesti::where('id',$id)->first();
        return view('main.admin.clients.testi.edit',compact('orderCounts','clientTestis'));
    }

    //review update
    public function reviewUpdate(Request $request){
        $data = $this->getReviewData($request);
        $this->reviewValidationCheck($request);
        clientTesti::where('id',$request->clientReviewId)->update($data);
        return redirect()->route('review#list')->with(['updateSuccess'=>'The client review was updated successfully!']);
    }

    //review delete
    public function reviewDelete($id, Request $request){
        $data = $this->getReviewData($request);
        clientTesti::where('id',$id)->delete($data);
        return back()->with(['deleteSuccess'=>'The client review was deleted successfully!']);
    }

    //get review data
    private function getReviewData($request){
        return[
            'name' => $request->clientName,
            'position' => $request->clientPosition,
            'description' => $request->clientDescription
        ];
    }

    //review validation check
    private function reviewValidationCheck($request){
        Validator::make($request->all(),[
            'clientName' => 'required',
            'clientPosition' => 'required',
            'clientDescription' => 'required'
        ])->validate();
    }


    //account list
    public function accountList(){
        $orderCounts = order::where('status','0')->get();
        $users = User::where('role','user')->paginate(30);
        return view('main.admin.clients.account.list',compact('orderCounts','users'));
    }

    //account add page
    public function accountAdd(){
        $orderCounts = order::where('status','0')->get();
        $permissions = clientPer::get();
        return view('main.admin.clients.account.add',compact('orderCounts','permissions'));
    }

    //account create
    public function accountCreate(Request $request){
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'permission' => 'required',
            'password' => 'required|min:6|max:30',
            'password_confirmation' => 'required|min:6|max:30|same:password'
        ])->validate();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'project_permission' => $request->permission,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('account#list')->with(['success'=>'The client account was created successfully!']);
    }

    //account edit
    public function accountEdit($id){
        $orderCounts = order::where('status','0')->get();
        $permissions = clientPer::get();
        $users = User::where('id',$id)->first();
        return view('main.admin.clients.account.edit',compact('orderCounts','permissions','users'));
    }

    // account update
    public function accountUpdate(Request $request){
        $users = User::where('id',$request->userId)->first();
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($users->id),
            ],
            'permission' => 'required'
        ])->validate();

        $users->update([
            'name' => $request->name,
            'email' => $request->email,
            'project_permission' => $request->permission
        ]);

        return redirect()->route('account#list')->with(['updateSuccess'=>'The client account was updated successfully!']);
    }

    //account delete
    public function accountDelete($id){
        User::findOrFail($id)->delete();
        return back()->with(['deleteSuccess'=>'The client account was deleted successfully!']);
    }
}
