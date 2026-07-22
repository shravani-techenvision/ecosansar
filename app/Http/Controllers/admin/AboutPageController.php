<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutSection;
use App\Models\Journey;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\frontend\UserActivityLog;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminActivityLog;

class AboutPageController extends Controller
{

    public function index()
    {
        $about = AboutSection::first();

        $journeys = Journey::orderBy('position')->get();

        $teams = TeamMember::orderBy('member_position')->get();
        
        // user activity start
        $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Viewed About Us page management';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return view('admin.about.index', compact(
            'about',
            'journeys',
            'teams'
        ));
    }
    
    private function resizeImage($source, $width, $height)
    {
        list($originalWidth, $originalHeight, $type) = getimagesize($source);
    
        $ratio = $originalWidth / $originalHeight;
    
        if (($width / $height) > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }
    
        $newImage = imagecreatetruecolor($width, $height);
    
        switch ($type) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($source);
                break;
    
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($source);
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
                break;
    
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($source);
                break;
    
            case IMAGETYPE_WEBP:
                $sourceImage = imagecreatefromwebp($source);
                break;
    
            default:
                throw new \Exception('Unsupported image type');
        }
    
        imagecopyresampled(
            $newImage,
            $sourceImage,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $originalWidth,
            $originalHeight
        );
    
        ob_start();
    
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($newImage, null, 90);
                break;
    
            case IMAGETYPE_PNG:
                imagepng($newImage);
                break;
    
            case IMAGETYPE_GIF:
                imagegif($newImage);
                break;
    
            case IMAGETYPE_WEBP:
                imagewebp($newImage, null, 90);
                break;
        }
    
        $imageContent = ob_get_clean();
    
        imagedestroy($newImage);
        imagedestroy($sourceImage);
    
        return $imageContent;
    }

    public function updateAbout(Request $request)
    {
        $about = AboutSection::first();
    
        if (!$about) {
            $about = new AboutSection();
        }
    
        $about->title = $request->title;
        $about->subtitle = $request->subtitle;
        $about->description1 = $request->description1;
        $about->description2 = $request->description2;
    
        if ($request->hasFile('image')) {
    
            $file = $request->file('image');
    
            $fileName = 'about_' . time() . '.' . $file->getClientOriginalExtension();
    
            $folder = 'about';
    
            $resizedImage = $this->resizeImage(
                $file->getRealPath(),
                800,
                600
            );
    
            Storage::disk('s3')->put(
                $folder . '/' . $fileName,
                $resizedImage
            );
    
            $about->image = $fileName;
        }
    
        $about->save();
        
        // user activity start
        $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Updated About Us page introduction content';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
        Alert::success('success', 'Updated Successfully');
        return redirect()->back();
    }

    public function saveJourney(Request $request)
    {
        
       $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|string|max:255',
            'description' => 'required|string',
            'position' => [
                'required',
                Rule::unique('journeys', 'position')->ignore($request->id),
            ],
            'image' => $request->id
                ? 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048'
                : 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'title.required' => 'Please enter the journey title.',
            'date.required' => 'Please enter the journey date.',
            'description.required' => 'Please enter the journey description.',
            'position.required' => 'Please enter the display order.',
            'position.unique' => 'This display order already exists. Please choose another.',
        
            'image.required' => 'Please upload a journey image.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Journey image must be a JPG, JPEG, PNG or WEBP file.',
            'image.max' => 'Journey image size must not exceed 2 MB.',
        ]);
        $journey = Journey::updateOrCreate(
    
            ['id' => $request->id],
    
            [
    
                'title' => $request->title,
    
                'date' => $request->date,
    
                'description' => $request->description,
    
                'position' => $request->position
    
            ]
    
        );
    
        if ($request->hasFile('image')) {
    
            $file = $request->file('image');
    
            $fileName = 'journey_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    
            $folder = 'journey';
    
            $resizedImage = $this->resizeImage(
                $file->getRealPath(),
                800,
                600
            );
    
            Storage::disk('s3')->put(
                $folder . '/' . $fileName,
                $resizedImage
            );
    
            $journey->image = $fileName;
    
            $journey->save();
        }
        
        // user activity start
        $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Added new journey milestone';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
    
        return redirect()->route('admin.about.index')->with('success', 'Journey Saved');
    }
    public function editJourney($id)
    {
        $about = AboutSection::first();
        $journeys = Journey::orderBy('position')->get();
        $teams = TeamMember::orderBy('member_position')->get();
    
        $editJourney = Journey::findOrFail($id);
        
        // user activity start
        $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Opened journey milestone for editing';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
    
        return view('admin.about.index', compact(
            'about',
            'journeys',
            'teams',
            'editJourney'
        ));
    }

    public function deleteJourney($id)
    {
        Journey::findOrFail($id)->delete();
        
        
        // user activity start
            $userid = Auth::id();
            if ($userid){
                $userActivity = new AdminActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'Deleted journey milestone';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
            // user activity end
    
        return back();
    }

    public function saveTeam(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'linkedin' => 'nullable|url|max:255',
            'member_position' => [
                'required',
                Rule::unique('team_members', 'member_position')->ignore($request->id),
            ],
            'status' => 'required|in:0,1',
            'image' => $request->id
                ? 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048'
                : 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'name.required' => 'Please enter member name.',
            'designation.required' => 'Please enter designation.',
            'linkedin.url' => 'Please enter a valid LinkedIn URL.',
            'member_position.required' => 'Please enter display order.',
            'member_position.unique' => 'This display order already exists. Please choose another.',
            'status.required' => 'Please select status.',
        
            'image.required' => 'Please upload a profile image.',
            'image.image' => 'The selected file must be an image.',
            'image.mimes' => 'Profile image must be a JPG, JPEG, PNG or WEBP file.',
            'image.max' => 'Profile image size must not exceed 2 MB.',
        ]);
        $team = TeamMember::updateOrCreate(
    
            ['id' => $request->id],
    
            [
    
                'name' => $request->name,
    
                'designation' => $request->designation,
    
                'linkedin' => $request->linkedin,
    
                'member_position' => $request->member_position,
    
                'status' => $request->status
    
            ]
    
        );
    
        if ($request->hasFile('image')) {
    
            $file = $request->file('image');
    
            $fileName = 'team_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    
            $folder = 'team';
    
            $resizedImage = $this->resizeImage(
                $file->getRealPath(),
                500,
                500
            );
    
            Storage::disk('s3')->put(
                $folder . '/' . $fileName,
                $resizedImage
            );
    
            $team->image = $fileName;
    
            $team->save();
            
            // user activity start
            $userid = Auth::id();
            if ($userid){
                $userActivity = new AdminActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'Added new team member';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
            // user activity end
        }
    
        return redirect()->route('admin.about.index')->with('success', 'Team Member Saved');
    }
    
    public function editTeam($id)
    {
        $about = AboutSection::first();
        $journeys = Journey::orderBy('position')->get();
        $teams = TeamMember::orderBy('member_position')->get();
    
        $editTeam = TeamMember::findOrFail($id);
        
        // user activity start
        $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Opened team member for editing';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
    
        return view('admin.about.index', compact(
            'about',
            'journeys',
            'teams',
            'editTeam'
        ));
    }

    public function deleteTeam($id)
    {
        TeamMember::findOrFail($id)->delete();
        
        // user activity start
        $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Deleted team member';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
    
        return redirect()->route('admin.about.index')->with('success', 'Team Member Deleted');
    }

}