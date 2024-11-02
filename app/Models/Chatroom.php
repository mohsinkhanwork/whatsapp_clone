<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'max_members'];

    public function members()
    {
        return $this->belongsToMany(User::class, 'chatroom_members');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
