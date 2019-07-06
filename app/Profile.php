<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','first_name','last_name','phone_no','mobile_no','address',
        'city','state','zip','profile_pic'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
