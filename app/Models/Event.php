<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'date', 'image'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class);
    }





}

