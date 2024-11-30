<?php

namespace App\Http\Controllers;

use App\Models\info;
use App\Models\order;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InfoController extends Controller
{
    //info add page
    public function infoAdd(){
        $orderCounts = order::where('status','0')->get();
        return view('main.admin.info.add',compact('orderCounts'));
    }

    //info create
    public function infoCreate(Request $request){
        $data = $this->getInfoData($request);
        $this->infoValidationCheck($request,'create');

        $customText = 'logo';
        $fileName = $customText.$request->file('logoImage')->getClientOriginalName();
        $request->file('logoImage')->storeAs('website',$fileName,'public');
        $data['logo_image'] = $fileName;

        info::create($data);
        return redirect()->route('info#list')->with(['success'=>'The information were created successfully.']);
    }

    //info list
    public function infoList(){
        $infos = info::first();
        $orderCounts = order::where('status','0')->get();
        return view('main.admin.info.view',compact('infos','orderCounts'));
    }

    //info update
    public function infoUpdate($id, Request $request){
        $data = $this->getInfoData($request);
        $this->infoValidationCheck($request,'update');

        if($request->hasFile('logoImage')){
            $oldImage = info::where('id',$request->infoId)->value('logo_image');

            $customText = 'logo';
            $fileName = $customText.$request->file('logoImage')->getClientOriginalName();
            $request->file('logoImage')->storeAs('website',$fileName,'public');
            $data['logo_image'] = $fileName;

            if($oldImage != null){
                $oldImagePath = storage_path('app/public/website/'.$oldImage);
                if(file_exists($oldImagePath)){
                    unlink($oldImagePath);
                }
            }
        }

        info::where('id',$request->infoId)->update($data);
        return back()->with(['updateSuccess'=>'The information was updated successfully!']);
    }

     //get info data
    private function getInfoData($request){
        return [
            'home_letter' => $request->homeLetter,
            'service_letter' => $request->serviceLetter,
            'service_price' => $request->servicePrice,
            'about_letter' => $request->aboutLetter,
            'contact_letter' => $request->contactLetter,
            'contact_phone' => $request->contactNumber,
            'contact_email' => $request->contactEmail
        ];
    }

    //info validation check
    private function infoValidationCheck($request,$action){
        $validationRules = [
            'homeLetter' => 'required',
            'serviceLetter' => 'required',
            'servicePrice' => 'required',
            'aboutLetter' => 'required',
            'contactLetter' => 'required',
            'contactNumber' => 'required|min:11|max:15',
            'contactEmail' => 'required'
        ];

        $validationRules['logoImage'] = $action == 'create' ? 'required|mimes:png,jpg,jpeg,webp,avif|file' : 'mimes:png,jpg,jpeg,webp,avif|file';
        Validator::make($request->all(),$validationRules)->validate();
    }
}
