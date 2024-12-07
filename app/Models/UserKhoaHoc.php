<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserKhoaHoc extends Model
{
    protected $table = 'user_khoa_hoc';
    protected $fillable = ['user_id', 'khoa_hoc_id', 'expiry_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function khoaHoc() 
    {
        return $this->belongsTo(KhoaHoc::class);
    }
}