<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\BreadcrumImage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
      public function add(){
        $url = route('breadcrumimage.save');
        return view('admin/breadcrumimage/add',compact('url'));
    }
    public function save(Request $request){
        
        $request->validate([
            'breadcrumb_image' => 'required',
        ]);
       
           $breadcrumbimage = new BreadcrumImage();     
       // Function to resize an image using the GD library
function resizeImage($source, $width, $height)
{
    // Get the original image dimensions and type
    list($originalWidth, $originalHeight, $type) = getimagesize($source);

    // Calculate the new dimensions while maintaining the aspect ratio
    $ratio = $originalWidth / $originalHeight;
    if ($width / $height > $ratio) {
        $width = $height * $ratio;
    } else {
        $height = $width / $ratio;
    }

    // Create a new blank image with the calculated dimensions
    $newImage = imagecreatetruecolor($width, $height);

    // Load the source image based on its type
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
            throw new Exception('Unsupported image type');
    }

    // Resize the image
    imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

    // Start output buffering to capture the image content
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
    $imageContent = ob_get_clean(); // Get the image content from the buffer

    // Free up memory
    imagedestroy($newImage);
    imagedestroy($sourceImage);

    return $imageContent; // Return the resized image content as a binary string
}

// Upload file to S3
    if ($request->hasFile('breadcrumb_image')) {
        $file = $request->file('breadcrumb_image');
        $filePath = 'Breadcrumbimage';
        
        $fileName = 'breadcrumb_' . time() . '.' . $file->getClientOriginalExtension();;
        
          $fileTempPath = $file->getRealPath(); // Get the temporary file path

    // Set desired dimensions for resizing (e.g., 800px wide)
    $newWidth = 800;
    $newHeight = 600; // You can adjust this based on your aspect ratio logic

    // Use the resizeImage function to get the resized image content
    $resizedImageContent = resizeImage($fileTempPath, $newWidth, $newHeight);

    // Upload to S3
    Storage::disk('s3')->put($filePath . '/' . $fileName, $resizedImageContent);
$breadcrumbimage->breadcrumb_image = $fileName;
    }
 $breadcrumbimage->save();
        Alert::success('success','BreadcrumImage added successfully');
        return redirect()->route('breadcrumimage.add');
    }
    public function edit($id){
        $url = route('breadcrumimage.update',$id);
        $breadcrumbimage = BreadcrumImage::findOrFail($id);
        return view('admin/breadcrumimage/add',compact('url','breadcrumbimage'));
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'breadcrumb_image' => 'required',
    ]);

    $breadcrumbimage = BreadcrumImage::findOrFail($id);
       // Function to resize an image using the GD library
function resizeImage($source, $width, $height)
{
    // Get the original image dimensions and type
    list($originalWidth, $originalHeight, $type) = getimagesize($source);

    // Calculate the new dimensions while maintaining the aspect ratio
    $ratio = $originalWidth / $originalHeight;
    if ($width / $height > $ratio) {
        $width = $height * $ratio;
    } else {
        $height = $width / $ratio;
    }

    // Create a new blank image with the calculated dimensions
    $newImage = imagecreatetruecolor($width, $height);

    // Load the source image based on its type
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
            throw new Exception('Unsupported image type');
    }

    // Resize the image
    imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

    // Start output buffering to capture the image content
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
    $imageContent = ob_get_clean(); // Get the image content from the buffer

    // Free up memory
    imagedestroy($newImage);
    imagedestroy($sourceImage);

    return $imageContent; // Return the resized image content as a binary string
}

// Upload file to S3
    if ($request->hasFile('breadcrumb_image')) {
        $file = $request->file('breadcrumb_image');
        $filePath = 'Breadcrumbimage';
        
        $fileName = 'breadcrumb_' . time() . '.' . $file->getClientOriginalExtension();;
        
          $fileTempPath = $file->getRealPath(); // Get the temporary file path

    // Set desired dimensions for resizing (e.g., 800px wide)
    $newWidth = 800;
    $newHeight = 600; // You can adjust this based on your aspect ratio logic

    // Use the resizeImage function to get the resized image content
    $resizedImageContent = resizeImage($fileTempPath, $newWidth, $newHeight);

    // Upload to S3
    Storage::disk('s3')->put($filePath . '/' . $fileName, $resizedImageContent);
$breadcrumbimage->breadcrumb_image = $fileName;
    }
 $breadcrumbimage->save();

    Alert::success('success', 'BreadcrumImage updated successfully');
    return redirect()->route('breadcrumimage.edit', $id);
}

}
