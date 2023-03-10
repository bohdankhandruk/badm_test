<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Organization extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'trial_end',
        'subscribed',
        'user_id',
    ];

    /**
     * Get the user of the organization.
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
