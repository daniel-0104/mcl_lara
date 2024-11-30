<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\message;
use Illuminate\Http\Request;
use App\Mail\MessageReplyMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    //user message page
    public function messagePage(){
        return view('main.user.message.view');
    }

    // user message send
    public function messageSend(Request $request){
        $data = $this->getMessageData($request);
        $this->messageValidationCheck($request);
        message::create($data);
        return back()->with(['success'=>'Your message was sent successfully.']);
    }

    //admin message page
    public function adminMessagePage(){
        $orderCounts = order::where('status','0')->get();
        $messages = message::orderBy('id','desc')->paginate(20);
        return view('main.admin.message.view',compact('messages','orderCounts'));
    }

    //admin message reply
    public function adminMessageReply($id){
        $messages = message::findOrFail($id);
        $orderCounts = order::where('status','0')->get();
        return view('main.admin.message.reply',compact('messages','orderCounts'));
    }

    //admin message send
    public function adminMessageSend($id,Request $request){
        $validated = $request->validate([
            'message' => 'required|string'
        ]);
        $messages = message::findOrFail($id);
        $name = $messages->name;

        $formattedMessage = nl2br(e($validated['message']));

        Mail::to($messages->email)->send(new MessageReplyMail($validated['message'],$formattedMessage,$name));

        $messages->status = 'read';
        $messages->save();

        return redirect()->route('admin#message')->with(['success'=>'The reply was sent successfully!']);
    }

    //admin message delete
    public function adminMessageDelete(Request $request,$id){
        $data = $this->getMessageData($request);
        message::where('id',$id)->delete($data);
        return back()->with(['deleteSuccess'=>'The message was deleted successfully!']);
    }

    // get messsage data
    private function getMessageData($request){
        return[
            'name' => $request->name,
            'email' => $request->email,
            'website_name' => $request->websiteName,
            'message' => $request->message
        ];
    }

    //message validation chcek
    private function messageValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'websiteName' => 'required',
            'message' => 'required'
        ])->validate();
    }
}
