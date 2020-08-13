<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getCover()
    {
        if(substr($this->cover, 0, 5) == "https") {
            return $this->cover;
        }

        if($this->cover) {
            return asset($this->cover);
        }

        return 'https://via.placeholder.com/150x200.png?text=No+Cover';
    }
}
