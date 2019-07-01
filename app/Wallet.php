<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'name', 'money', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function expends()
    {
        return $this->hasMany('App\Expend');
    }
}
