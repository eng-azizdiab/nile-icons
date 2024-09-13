<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\StoreReferenceRequest;
use App\Models\Partner;
use App\Models\Partner2;
use App\Models\Reference;
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
    public function store_partner(StorePartnerRequest $request)
    {
        foreach ($request->partners as $partnerData) {
            // Handle the image upload
           // $imagePath = $partnerData['image']->store('partner_images', 'public');

            // Create the partner record
           $partner= Partner::create([
                'name' => $partnerData['name'],
            ]);
           $partner->partner_file= $partnerData['image'];
        }
         //  dd($request);

        return response()->json(['message' => 'Partners created successfully']);
       /* dd($request->all());
       $this->delete_Create_Directory(self::LOGOS);

       if($this->pass_RequestFiles($request,self::LOGOS)){
          return response()->json('uploaded successfully');
       }else{
           return response()->json('no files uploaded');
       }*/

    }
    public function get_partner()
    {

        //$fileUrls= $this->getAllFiles(self::LOGOS);
        $partners = Partner::all();
        return response()->json([
            'message' => 'Partners retrieved successfully.',
            'files' => $partners
        ], 200);
    }

    public function delete_partner($id)
    {
        $partner=Partner::find($id);

        if ($partner){
            $partner->delete();
            return response()->json([
                'message' => 'Deleted successfully.']);
        }else{
            return response()->json([
                'message' => 'Partner not found.'
            ]);
        }

    }
    public function store_partner2(StorePartnerRequest $request)
    {

        foreach ($request->partners as $partnerData) {
            // Handle the image upload
           // $imagePath = $partnerData['image']->store('partner_images', 'public');

            // Create the partner record
           $partner= Partner2::create([
                'name' => $partnerData['name'],
            ]);
           $partner->partner_file= $partnerData['image'];
        }
         //  dd($request);

        return response()->json(['message' => 'Partners2 created successfully']);
       /* dd($request->all());
       $this->delete_Create_Directory(self::LOGOS);

       if($this->pass_RequestFiles($request,self::LOGOS)){
          return response()->json('uploaded successfully');
       }else{
           return response()->json('no files uploaded');
       }*/

    }
    public function get_partner2()
    {

        //$fileUrls= $this->getAllFiles(self::LOGOS);
        $partners = Partner2::all();
        return response()->json([
            'message' => 'Partners2 retrieved successfully.',
            'files' => $partners
        ], 200);
    }

    public function delete_partner2($id)
    {
        $partner=Partner2::find($id);

        if ($partner){
            $partner->delete();
            return response()->json([
                'message' => 'Deleted successfully.']);
        }else{
            return response()->json([
                'message' => 'Partner not found.'
            ]);
        }

    }

    public function store_reference(StoreReferenceRequest $request){

        foreach ($request->references as $referenceData) {

            $reference= Reference::create([
                'company_name' => $referenceData['name'],
            ]);
            $reference->reference_file= $referenceData['image'];
        }

        return response()->json(['message' => 'References created successfully']);

        /*$this->delete_Create_Directory(self::SLIDER1);

        if($this->pass_RequestFiles($request,self::SLIDER1)){
            return response()->json('uploaded successfully');
        }else{
            return response()->json('no files uploaded');
        }*/
    }



    public function get_reference()
    {
        $references = Reference::all();
        return response()->json([
            'message' => 'References retrieved successfully.',
            'files' => $references
        ], 200);
    }

    public function delete_reference($id)
    {
        $reference=Reference::find($id);
        if ($reference){
            $reference->delete();
            return response()->json([
                'message' => 'Deleted successfully.']);
        }else{
            return response()->json([
                'message' => 'Reference not found.'
            ]);
        }

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
