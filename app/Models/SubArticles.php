<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubArticles extends Model
{
    use HasFactory;
    protected $table='sub_articles';
    protected $fillable=['title','article_id','description','image_path','image_position'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image_path? url('storage/' . $this->image_path):null ; // Adjust the URL to match your storage structure
    }

    public function article(){
        return $this->belongsTo(Articles::class,'article_id','id');
    }
}
