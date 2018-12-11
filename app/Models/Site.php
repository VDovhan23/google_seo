<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Site extends Model
{

    protected $guarded=[];

    public function sites(){
        return $this->belongsTo(User::class);
    }

}
