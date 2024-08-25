<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AttachmentsController extends Controller
{
    //
    const SLIDER1='Slider1';
    const LOGOS='Logos';
    const SLIDER2='Slider2';
    public function upload_logos(Request $request)
    {

       $this->delete_Create_Directory(self::LOGOS);

       if($this->pass_RequestFiles($request,self::LOGOS)){
          return response()->json('uploaded successfully');
       }else{
           return response()->json('no files uploaded');
       }

    }
    public function get_logos()
    {

        $fileUrls= $this->getAllFiles(self::LOGOS);
        return response()->json([
            'message' => 'Files retrieved successfully.',
            'files' => $fileUrls
        ], 200);
    }

    public function upload_slider1(Request $request){

        $this->delete_Create_Directory(self::SLIDER1);

        if($this->pass_RequestFiles($request,self::SLIDER1)){
            return response()->json('uploaded successfully');
        }else{
            return response()->json('no files uploaded');
        }
    }

    public function get_slider1()
    {
        $fileUrls= $this->getAllFiles(self::SLIDER1);
        return response()->json([
            'message' => 'Files retrieved successfully.',
            'files' => $fileUrls
        ], 200);
    }
    public function upload_slider2(Request $request){

        $this->delete_Create_Directory(self::SLIDER2);

        if($this->pass_RequestFiles($request,self::SLIDER2)){
            return response()->json('uploaded successfully');
        }else{
            return response()->json('no files uploaded');
        }
    }

    public function get_slider2()
    {
        $fileUrls= $this->getAllFiles(self::SLIDER2);
        return response()->json([
            'message' => 'Files retrieved successfully.',
            'files' => $fileUrls
        ], 200);
    }
    private function uploadAttachment( $image = null,$folderPath = null)
    {

        if ($image != null) {
            $format = $image?->extension() ?? null;
            $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
            if (!Storage::disk('public')->exists($folderPath)) {
                Storage::disk('public')->makeDirectory($folderPath);
            }
            Storage::disk('public')->put($folderPath.'/' . $imageName, file_get_contents($image));
        }
    }

    private function delete_Create_Directory($folderPath){
        if (Storage::disk('public')->exists($folderPath)){
            Storage::disk('public')->deleteDirectory($folderPath);
        }
        Storage::disk('public')->makeDirectory($folderPath);
    }

    private function getAllFiles($folderPath)
    {
        $files = Storage::disk('public')->files($folderPath);

        $fileUrls = [];

        // Loop through the files and get their URLs
        foreach ($files as $file) {
            $fileUrls[]  = url(Storage::url($file)); // Correctly generate the URL
        }

        // Return the file URLs in a JSON response
        return $fileUrls;
    }
    public function pass_RequestFiles($request,$folderPath)
    {
      //  dd(response()->json($request));
        if (count($request->allFiles())>0){
            foreach ($request->allFiles() as $file) {
                $this->uploadAttachment($file,$folderPath);
            }
            return true;
        }else{
            return false;
        }
    }

}
