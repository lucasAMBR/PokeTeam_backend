<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pokemon extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'image_url', 'name', 'types'];
    
    protected $casts = [
        'types' => 'array',
    ];


    public function team(){
        return $this->belongsTo(Team::class);
    }

}
