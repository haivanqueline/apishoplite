<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    // Khai báo các trường có thể gán hàng loạt
    protected $fillable = [
        'user_id',
        'card_number',
        'card_holder_name',
        'cvv',
        'expiration_month',
        'expiration_year'
    ];

    // Thiết lập mối quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}