<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plugins extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'current' , 'ss', 'sp', 'sec', 'sa', 'su', 'spp', 'sn', 'se', 'status'
    ];
    
}
