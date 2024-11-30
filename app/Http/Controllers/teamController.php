<?php

namespace App\Http\Controllers;

use Log;
use App\Models\team;
use App\Models\order;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class teamController extends Controller
{
    //teams add page
    public function teamAdd(){
        $orderCounts = order::where('status','0')->get();
        return view('main.admin.teams.add',compact('orderCounts'));
    }

    //team members create
    public function teamCreate(Request $request){
        $data = $this->getTeamData($request);
        $this->teamValidationCheck($request,'create');

        $customText = 'member';
        $fileName = $customText.$request->file('memberImage')->getClientOriginalName();
        $request->file('memberImage')->storeAs('members',$fileName,'public');
        $data['image'] = $fileName;

        team::create($data);
        return redirect()->route('team#list')->with(['success'=>'The member was created successfully.']);
    }

    //team members list
    public function teamList(){
        $teams = team::orderBy('id','desc')->paginate(10);
        $orderCounts = order::where('status','0')->get();
        return view('main.admin.teams.list',compact('teams','orderCounts'));
    }

    // team member edit
    public function teamEdit($id, Request $request){
        $teams = team::where('id',$id)->first();
        $orderCounts = order::where('status','0')->get();
        return view('main.admin.teams.edit',compact('teams','orderCounts'));
    }

    //team member update
    public function teamUpdate(Request $request){
        $data = $this->getTeamData($request);
        $this->teamValidationCheck($request,'update');

        if($request->hasFile('memberImage')){
            $oldImage = team::where('id', $request->teamId)->value('image');

            $customText = 'member';
            $fileName = $customText.$request->file('memberImage')->getClientOriginalName();
            $request->file('memberImage')->storeAs('members',$fileName,'public');
            $data['image'] = $fileName;

            if($oldImage != null){
                $oldImagePath = storage_path('app/public/members/'.$oldImage);
                if(file_exists($oldImagePath)){
                    unlink($oldImagePath);
                }
            }
        }

        team::where('id',$request->teamId)->update($data);
        return back()->with(['updateSuccess'=>'The member was updated successfully!']);
    }

    //team member delete
    public function teamDelete($id){
        $teams = team::find($id);
        $imagePath = public_path('storage/members/'.$teams->image);
        if(file_exists($imagePath)){
            unlink($imagePath);
        }
        $teams->delete();
        return back()->with(['deleteSuccess'=>'The member was deleted successfully!']);
    }

    // get team data
    private function getTeamData($request){
        return[
            'name' => $request->memberName,
            'position' => $request->memberPosition,
            // 'image' => $request->hasFile('memberImage') ? $request->memberImage : null
        ];
    }

    //team validation check
    private function teamValidationCheck($request,$action){
        $validatedRules = [
            'memberName' => 'required',
            'memberPosition' => 'required'
        ];

        $validatedRules['memberImage'] = $action == 'create' ? 'required|mimes:png,jpg,webp,jpeg,avif|file' : 'mimes:png,jpg,webp,jpeg,avif|file';
        Validator::make($request->all(),$validatedRules)->validate();
    }
}
