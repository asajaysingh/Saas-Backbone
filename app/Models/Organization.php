<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'name',
        'owner_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
        ->withPivot('role')
        ->withTimestamps();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
