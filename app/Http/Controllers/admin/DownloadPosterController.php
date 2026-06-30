<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DownloadPoster;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class DownloadPosterController extends Controller
{
    public function index()
    {
        $posters = DownloadPoster::latest()->get();

        return view('admin.download_posters.index', compact('posters'));
    }

    public function create()
    {
        $url = route('download_posters.store');
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

            Storage::disk('s3')->put(
                $filePath.'/'.$fileName,
                $resizedImage
            );

            $poster->poster_image = $fileName;
        }

        // Upload PDF
        if ($request->hasFile('poster_pdf')) {

            $pdf = $request->file('poster_pdf');

            $pdfPath = 'DownloadPosters/PDF';

            $pdfName = $poster->id.'_'.uniqid().'.'.$pdf->getClientOriginalExtension();

            Storage::disk('s3')->putFileAs(
                $pdfPath,
                $pdf,
                $pdfName
            );

            $poster->poster_pdf = $pdfName;
        }

        $poster->save();

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

        return view('admin.download_posters.edit', compact('poster'));
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

                Storage::disk('s3')->delete(
                    'DownloadPosters/Image/'.$poster->poster_image
                );
            }

            $file = $request->file('poster_image');

            $fileName = $poster->id.'_'.uniqid().'.'.$file->getClientOriginalExtension();

            $resizedImage = resizeImage(
                $file->getRealPath(),
                800,
                600
            );

            Storage::disk('s3')->put(
                'DownloadPosters/Image/'.$fileName,
                $resizedImage
            );

            $poster->poster_image = $fileName;
        }

        /* Update PDF */

        if ($request->hasFile('poster_pdf')) {

            if ($poster->poster_pdf) {

                Storage::disk('s3')->delete(
                    'DownloadPosters/PDF/'.$poster->poster_pdf
                );
            }

            $pdf = $request->file('poster_pdf');

            $pdfName = $poster->id.'_'.uniqid().'.'.$pdf->getClientOriginalExtension();

            Storage::disk('s3')->putFileAs(
                'DownloadPosters/PDF',
                $pdf,
                $pdfName
            );

            $poster->poster_pdf = $pdfName;
        }

        $poster->save();

        return redirect()->route('download-posters.index')
            ->with('success','Poster updated successfully.');
    }

    public function destroy($id)
    {
        $poster = DownloadPoster::findOrFail($id);

        $poster->delete();
        Alert::success('success','Poster deleted successfully.');
        return redirect()->back();
    }

    public function changeStatus(Request $request)
    {
        $poster = DownloadPoster::findOrFail($request->id);

        $poster->status = $poster->status == 1 ? 0 : 1;

        $poster->save();

        return response()->json([
            'success' => true,
            'status' => $poster->status
        ]);
    }
}