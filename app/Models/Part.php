<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Part
 *
 * @mixin \Eloquent
 */
class Part extends Model
{
    public function site(){
        return $this->belongsTo(Site::class);
    }
}
