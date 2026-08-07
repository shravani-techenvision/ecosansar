<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DownloadPoster;
use App\Models\DownloadPosterEnquiry;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\frontend\UserActivityLog;
use Illuminate\Support\Facades\Auth;

class DownloadPosterController extends Controller
{
    public function index()
    {
        $posters = DownloadPoster::latest()->get();
        $userid = Auth::id();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Viewed Download Posters list';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return view('admin.download_posters.index', compact('posters'));
    }

    public function create()
    {
        $url = route('download_posters.store');
        $userid = Auth::id();
       
        // user activity end
        return view('admin.download_posters.create', compact('url'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'poster_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'poster_pdf' => 'required|mimes:pdf|max:20480',
        ]);

        $poster = new DownloadPoster();
        $poster->title = $request->title;
        $poster->status = 1;
        $poster->save();

        // Upload Image
        if ($request->hasFile('poster_image')) {

            $file = $request->file('poster_image');

            $filePath = 'DownloadPosters/Image';

            $fileName = $poster->id.'_'.uniqid().'.'.$file->getClientOriginalExtension();

            $resizedImage = $this->resizeImage(
                $file->getRealPath(),
                800,
                600
            );

            Storage::disk('public')->put(
                $filePath.'/'.$fileName,
                $resizedImage
            );

            $poster->poster_image = $filePath.'/'.$fileName;
        }

        // Upload PDF
        if ($request->hasFile('poster_pdf')) {

            $pdf = $request->file('poster_pdf');

            $pdfPath = 'DownloadPosters/PDF';

            $pdfName = $poster->id.'_'.uniqid().'.'.$pdf->getClientOriginalExtension();

            Storage::disk('public')->putFileAs(
                $pdfPath,
                $pdf,
                $pdfName
            );

            $poster->poster_pdf = $pdfPath.'/'.$pdfName;
        }

        $poster->save();
        $userid = Auth::id();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Added new download poster';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        Alert::success('success','Poster added successfully.');
        return redirect()->route('download_posters.index');
    }

    private function resizeImage($source, $width, $height)
    {
        list($originalWidth, $originalHeight, $type) = getimagesize($source);

        $ratio = $originalWidth / $originalHeight;

        if ($width / $height > $ratio) {
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
                imagejpeg($newImage);
                break;

            case IMAGETYPE_PNG:
                imagepng($newImage);
                break;

            case IMAGETYPE_GIF:
                imagegif($newImage);
                break;

            case IMAGETYPE_WEBP:
                imagewebp($newImage);
                break;
        }

        $imageContent = ob_get_clean();

        imagedestroy($newImage);
        imagedestroy($sourceImage);

        return $imageContent;
    }

    public function edit($id)
    {
        $poster = DownloadPoster::findOrFail($id);
        $url = route('download_posters.update', $poster->id);
        return view('admin.download_posters.create', compact('poster','url'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'poster_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'poster_pdf' => 'nullable|mimes:pdf|max:20480',
        ]);

        $poster = DownloadPoster::findOrFail($id);

        $poster->title = $request->title;

        /* Update Image */
        if ($request->hasFile('poster_image')) {

            if ($poster->poster_image) {

                Storage::disk('public')->delete(
                    $poster->poster_image
                );
            }

            $file = $request->file('poster_image');
            
            $fileName = $poster->id.'_'.uniqid().'.'.$file->getClientOriginalExtension();

            $resizedImage = resizeImage(
                $file->getRealPath(),
                800,
                600
            );

            Storage::disk('public')->put(
                'DownloadPosters/Image/'.$fileName,
                $resizedImage
            );

            $poster->poster_image = 'DownloadPosters/Image/'.$fileName;
        }

        /* Update PDF */

        if ($request->hasFile('poster_pdf')) {

            if ($poster->poster_pdf) {

                Storage::disk('public')->delete(
                    $poster->poster_pdf
                );
            }

            $pdf = $request->file('poster_pdf');

            $pdfName = $poster->id.'_'.uniqid().'.'.$pdf->getClientOriginalExtension();

            Storage::disk('public')->putFileAs(
                'DownloadPosters/PDF',
                $pdf,
                $pdfName
            );

            $poster->poster_pdf ='DownloadPosters/PDF/'.$pdfName;
        }

        $poster->save();
        $userid = Auth::id();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Updated download poster'.$id;
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        Alert::success('success','Poster updated successfully.');
        return redirect()->route('download_posters.index');
    }

    public function destroy($id)
    {
        $poster = DownloadPoster::findOrFail($id);

        $poster->delete();
        $userid = Auth::id();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Deleted download poster'.$id;
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
        Alert::success('success','Poster deleted successfully.');
        return redirect()->back();
    }

    public function changeStatus(Request $request)
    {
        $poster = DownloadPoster::findOrFail($request->id);

        $poster->status = $poster->status == 1 ? 0 : 1;

        $poster->save();
        $userid = Auth::id();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Changed download poster status'.$poster->id;
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return response()->json([
            'success' => true,
            'status' => $poster->status
        ]);
    }
    
    public function enquiryList()
    {
        $postersenquiry = DownloadPosterEnquiry::latest()->get();

        return view('admin.download_posters.enquiry', compact('postersenquiry'));
    }
    
    public function deleteEnquiry($id)
    {
        $enquiry = DownloadPosterEnquiry::findOrFail($id);
    
        $enquiry->delete();
        $userid = Auth::id();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Deleted Download Poster enquiry'.$id;
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
    
        Alert::success('success', 'Enquiry deleted successfully.');
        return redirect()->route('download_posters.enquiry');
    }
}