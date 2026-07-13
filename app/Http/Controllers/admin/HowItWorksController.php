<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\HowItWorksSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class HowItWorksController extends Controller
{
    // Admin page
    public function index()
    {
        $sections = HowItWorksSection::orderBy('position')->get();
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

            // S3 upload
            Storage::disk('s3')->put(
                "howitworks/".$fileName,
                file_get_contents($file)
            );

            $section->image = $fileName;
            $section->save();
        }

        return back()->with('success','Saved Successfully');
    }
    public function edit($id)
    {
        $sections = HowItWorksSection::orderBy('position')->get();
    
        $editSection = HowItWorksSection::findOrFail($id);
    
        return view('admin.howitworks.index', compact('sections', 'editSection'));
    }
    // Delete
    public function delete($id)
    {
        $section = HowItWorksSection::findOrFail($id);

        if ($section->image) {
            Storage::disk('s3')->delete("howitworks/".$section->image);
        }

        $section->delete();

        return back()->with('success','Deleted Successfully');
    }
}
