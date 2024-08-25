<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Interfaces\AttachmentsManagerInterface;
use App\Traits\AttachmentsManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements AttachmentsManagerInterface
{
    use HasApiTokens, HasFactory, Notifiable ,AttachmentsManager;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFolderName(): string
    {
        return"// TODO: Implement getFolderName() method." ;
    }
    public function attachments()
    {
        return $this->morphMany('App\Attachment', 'attachmentable');
    }

    public function setUserFileAttribute(File|UploadedFile $file)
    {

        $lastAttachment = $this->latest_attachment()->value('file_name');

        $attachment = $this->uploadAttachment($file, $lastAttachment);
        $this->attachments()->updateOrCreate([
            'attachmentable_id'=>$this->id,
            'attachmentable_type'=>self::class,
        ],[
            'file_name'=>$attachment,
            'client_name'=>$file->getClientOriginalName()
        ]);
    }
    public function latest_attachment(){
        return $this->attachments()->where('attribute', '=',null)->latest();
    }
    public function getUserFileUrlAttribute()
    {
        return $this->getAttachment($this->latest_attachment()->value('file_name'));
    }
}
