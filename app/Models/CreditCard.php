<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_number',
        'card_holder_name', 
        'expiration_month',
        'expiration_year',
        'cvv',
        'card_type',
        'is_default',
        'status'
    ];

    protected $hidden = [
        'cvv'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}