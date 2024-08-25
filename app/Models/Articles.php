<?php

namespace App\Models;

use App\Interfaces\AttachmentsManagerInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;

    protected $fillable=['title','description','user_id','image_path','slug','visible','category_id'];

    protected $appends = ['user_name', 'image_url','category_title'];

    public function getUserNameAttribute()
    {
        return $this->user->name ?? 'Unknown User';
    }
    public function getCategoryTitleAttribute()
    {
        return $this->category->title ?? 'Unknown Category';
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path? url('storage/' . $this->image_path):null ; // Adjust the URL to match your storage structure
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

}
