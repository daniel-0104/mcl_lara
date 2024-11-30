<?php

namespace App\Http\Controllers;

use Log;
use App\Models\order;
use App\Models\message;
use App\Models\project;
use App\Models\clientPer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    //project add
    public function projectAdd(){
        $orderCounts = order::where('status','0')->get();
        $permissions = clientPer::get();
        return view('main.admin.projects.add',compact('orderCounts','permissions'));
    }

    //project create
    public function projectCreate(Request $request){
        $data = $this->getProjectData($request);
        $this->projectValidationCheck($request,'create');

        if($request->hasFile('projectImages')){
            $imagePaths = [];
            $orderedFileNames = json_decode($request->input('orderedImages'), true);

            foreach ($request->file('projectImages') as $index => $image) {
                $fileName = 'project' . $image->getClientOriginalName();
                $image->storeAs('projects', $fileName, 'public');
                $imagePaths[$index] = $fileName;
            }

            $orderedPaths = [];
            if (is_array($orderedFileNames)) {
                foreach ($orderedFileNames as $fileIndex) {
                    $orderedPaths[] = $imagePaths[$fileIndex];
                }
            } else {
                $orderedPaths = array_values($imagePaths);
            }

            $data['images'] = json_encode($orderedPaths);
        }

        project::create($data);
        return redirect()->route('project#list')->with(['success'=>'The project was created successfully.']);
    }

    //project list
    public function projectList(){
        $orderCounts = order::where('status','0')->get();
        $projects = project::orderBy('id','desc')->paginate(30);
        return view('main.admin.projects.list',compact('orderCounts','projects'));
    }

    //project edit
    public function projectEdit($id){
        $orderCounts = order::where('status','0')->get();
        $projects = project::where('id',$id)->first();
        $permissions = clientPer::get();
        return view('main.admin.projects.view',compact('orderCounts','projects','permissions'));
    }

    //project update
    public function projectUpdate(Request $request){
        $data = $this->getProjectData($request);
        $this->projectValidationCheck($request,'update');
        $projects = project::where('id',$request->projectId)->first();

        if ($request->hasFile('projectImages')) {
            $existingImages = json_decode($projects->images, true) ?? [];
            foreach ($existingImages as $oldImage) {
                $oldImagePath = storage_path('app/public/projects/' . $oldImage);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $newImagesPath = [];
            $orderedFileNames = json_decode($request->input('orderedImages'), true);

            foreach ($request->file('projectImages') as $index => $image) {
                $fileName = 'project' . $image->getClientOriginalName();
                $image->storeAs('projects', $fileName, 'public');
                $newImagesPath[$index] = $fileName;
            }

            $orderedPaths = [];
            if (is_array($orderedFileNames)) {
                foreach ($orderedFileNames as $fileIndex) {
                    $orderedPaths[] = $newImagesPath[$fileIndex];
                }
            } else {
                $orderedPaths = array_values($newImagesPath);
            }

            $data['images'] = json_encode($orderedPaths);
        }


        $projects->update($data);
        return back()->with(['updateSuccess'=>'The project was updated successfully.']);
    }

    //project delete
    public function projectDelete($id){
        $projects = project::find($id);
        $existingImages = json_decode($projects->images) ?? [];
        foreach($existingImages as $oldImage){
            $oldImagePath = public_path('storage/projects/'.$oldImage);
            if(file_exists($oldImagePath)){
                unlink($oldImagePath);
            }
        }
        $projects->delete();
        return back()->with(['deleteSuccess'=>'The project was deleted successfully!']);
    }

    //get project data
    private function getProjectData($request){
        return[
            'name' => $request->projectName,
            'type' => $request->projectType,
            'project_permission' => $request->projectPermission,
            'paragraph1' => $request->projectPara1,
            'paragraph2' => $request->projectPara2,
            'project_duration' => $request->projectDuration,
            'website_link' => $request->projectLink,
            'price_letter' => $request->projectPriceLetter
        ];
    }

    //project validation check
    private function projectValidationCheck($request,$action){
        $validatedRules = [
            'projectName' => 'required',
            'projectType' => 'required',
            'projectPermission' => 'required',
            'projectPara1' => 'required',
            'projectPara2' => 'required',
            'projectDuration' => 'required',
            'projectLink' => 'required|url',
            'projectPriceLetter' => 'required',
            'projectImages.*' => 'mimes:png,jpg,jpeg,webp,avif|file'
        ];

        $validatedRules['projectImages'] = $action == 'create' ? 'required|array' : 'nullable|array';
        $messages = [
            'projectLink.url' => 'Please enter a valid URL.',
        ];

        Validator::make($request->all(),$validatedRules,$messages)->validate();
    }
}
