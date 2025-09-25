<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $fillable = [
        'user_id', 'rating', 'comment', 'status'
    ];

    // Relation with user table
    public function user(){
        return $this->belongsTo(User::class);
    }
}
