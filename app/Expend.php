<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expend extends Model
{
    protected $fillable = [
        'name', 'type', 'wallet_id', 'value','money_after','money_before'
    ];


    public function wallet()
    {
        return $this->belongsTo('App\Wallet');
    }
}
