<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'magv', 'name', 'email', 'phone_number', 'degree', 'biography', 'faculty', 'major', 'specialization', 'user_id',
    ];

    // Định nghĩa quan hệ với bảng users (nếu bạn cần truy xuất user liên quan tới lecturer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
