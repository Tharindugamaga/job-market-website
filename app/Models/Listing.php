<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'roles',
        'job_type',
        'address',
        'salary',
        'application_close_date',
        'feature_image',
        'slug',
    ];

    public function users()
    {
        return $this->BelongsToMany(User::class,'listing_user', 'listing_id', 'user_id')
        ->withPivot('shortlisted')
        ->withTimestamps();
    }
    public function profile()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }
    
}
