<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function category(){
        return $this->belongsTo("App\Category", "category_id", "id");
    }
    public function tag(){
        return $this->belongsToMany("App\Tag", "taggables", "photo_id", "tag_id");
    }
    public function photoDescription(){
        return $this->hasOne("App\PhotoDescription", "photo_id");
    }
}
