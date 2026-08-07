<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\HowItWorksSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\frontend\UserActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminActivityLog;

class HowItWorksController extends Controller
{
    // Admin page
    public function index()
    {
        $sections = HowItWorksSection::orderBy('position')->get();
        $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Viewed How It Works page management';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
        return view('admin.howitworks.index', compact('sections'));
    }

    
    // Save / Update
    public function save(Request $request)
    {
        $request->validate([
            'step_number' => 'required|max:10',
            'title' => 'required|max:255',
            'description' => 'required',
            'position' => [
                'required',
                'numeric',
                Rule::unique('how_it_works_sections', 'position')->ignore($request->id),
            ],
            'image' => $request->id
                ? 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048'
                : 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
    
        ], [
    
            'step_number.required' => 'Please enter the step number.',
    
            'title.required' => 'Please enter the title.',
    
            'description.required' => 'Please enter the description.',
    
            'position.required' => 'Please enter the display order.',
            'position.numeric' => 'Display order must be a number.',
            'position.unique' => 'This display order already exists. Please choose another.',
    
            'image.required' => 'Please upload an image.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Image must be JPG, JPEG, PNG or WEBP.',
            'image.max' => 'Image size must not exceed 2 MB.',
        ]);
        $section = HowItWorksSection::updateOrCreate(
            ['id' => $request->id],
            [
                'step_number' => $request->step_number,
                'title'       => $request->title,
                'description' => $request->description,
                'position'    => $request->position,
            ]
        );

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $fileName = time().'_'.$file->getClientOriginalName();

            Storage::disk('public')->put(
                "howitworks/".$fileName,
                file_get_contents($file)
            );

            $section->image = "howitworks/".$fileName;
            $section->save();
            
            
        }
        
        $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Added or updated new How It Works section';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return redirect()->route('admin.howitworks.index')->with('success','Saved Successfully');
    }
    public function edit($id)
    {
        $sections = HowItWorksSection::orderBy('position')->get();
    
        $editSection = HowItWorksSection::findOrFail($id);
        
        $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Opened How It Works section for editing'. $id;
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
    
        return view('admin.howitworks.index', compact('sections', 'editSection'));
    }
    // Delete
    public function delete($id)
    {
        $section = HowItWorksSection::findOrFail($id);

        if ($section->image) {
            Storage::disk('public')->delete($section->image);
        }

        $section->delete();
        
        $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Deleted How It Works section'. $id;
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return back()->with('success','Deleted Successfully');
    }
}
