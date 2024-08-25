<?php

namespace App\Helpers;

use App\Attachment;
use App\Interfaces\AttachmentsManagerInterface;
use App\Traits\AttachmentsManager;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ConsultancyAttachmentManage implements AttachmentsManagerInterface
{
    use AttachmentsManager;
    public $table;
    public $id;
    const CONSULTANCY_RESPONSE='consultancy_response';
    public function __construct($form_title,$id)
    {
        $this->table=$form_title ;
        $this->id=$id;
    }
    public function getFolderName(): string
    {
        return $this->table ;
    }

    public function uploadFormFile(File|UploadedFile $file,$attribute=null,$old_name=null)
    {
        if (($old_name==0)){
            $lastAttachment=null;
        }elseif ($old_name != 0){
            $lastAttachment=$old_name;
        }
        else {
            $lastAttachment = $this->latest_attachment($attribute)->value('file_name');
        }
        $attachment = $this->uploadAttachment($file, $lastAttachment);
        Attachment::updateOrCreate([
            'attachmentable_id' => $this->id,
            'attachmentable_type' => $this->table,
            'attribute' => $attribute,
            'file_name' => $lastAttachment,
        ], [
            'file_name' => $attachment,
            'client_name' => $file->getClientOriginalName()
        ]);
    }
    public function latest_attachment($attribute=null,$file_name=null)
    {
        return Attachment::where('attachmentable_type','=',  $this->table)
            ->where('attachmentable_id','=',  $this->id)
            ->when(isset($attribute), fn ($q) => $q->where('attribute', '=', $attribute))
            ->when(isset($file_name), fn ($q) => $q->where('file_name', '=',$file_name))->latest();
    }
    public function getFormFileUrl($attribute=null,$file_name=null)
    {
        return $this->getAttachment($this->latest_attachment($attribute,$file_name)->value('file_name'));
    }
    public function deleteConsultancyAttachment(?string $old_image)
    {
        if ($this->deleteAttachment($old_image)) {
            $this->latest_attachment()->where('file_name', $old_image)->delete();
        }
    }
}
