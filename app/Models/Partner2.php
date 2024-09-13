<?php

namespace App\Models;

use App\Interfaces\AttachmentsManagerInterface;
use App\Traits\AttachmentsManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Partner2 extends Model implements AttachmentsManagerInterface
{
    use HasFactory,AttachmentsManager;
    protected $table='partners2';
    protected $fillable=['name'];
    protected $appends = [ 'image_url'];
    public function getFolderName(): string
    {
        return $this->getTable();
    }

    public function attachments()
    {
        return $this->morphMany('App\Models\Attachment', 'attachmentable');
    }

    public function setPartnerFileAttribute(File|UploadedFile $file)
    {

        $lastAttachment = $this->latest_attachment()->value('file_name');

        $attachment = $this->uploadAttachment($file, $lastAttachment);
        $this->attachments()->updateOrCreate([
            'attachmentable_id' => $this->id,
            'attachmentable_type' => self::class,
        ], [
            'file_name' => $attachment,
            'client_name' => $file->getClientOriginalName()
        ]);
    }
    public function latest_attachment()
    {
        return $this->attachments()->where('attribute', '=', null)->latest();
    }
    public function getImageUrlAttribute()
    {
        if ($this->latest_attachment()->value('file_name') !=null)
            return $this->getAttachment($this->latest_attachment()->value('file_name'));
        else return null;
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($partner) {
            // Delete the related file from storage
            $deleted_file=$partner->latest_attachment()->value('file_name');
                if (!empty($deleted_file) && Storage::disk('public')->exists($partner->directory() . $deleted_file)) {
                    Storage::disk('public')->delete($partner->directory() . $deleted_file);
                }
                $partner->attachments()->delete();

        });
    }
 /*   public function getImageUrlAttribute()
    {
        return $this->image_path? url('storage/' . $this->image_path):null ; // Adjust the URL to match your storage structure
    }*/
}
