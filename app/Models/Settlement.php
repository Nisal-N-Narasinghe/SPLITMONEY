<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $fillable = ['group_id', 'paid_from', 'paid_to', 'amount', 'settled_at', 'note'];

     protected $casts = [
        'settled_at' => 'datetime',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'paid_from');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'paid_to');
    }
}