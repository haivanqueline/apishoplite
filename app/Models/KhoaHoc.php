<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhoaHoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'ten_khoa_hoc',
        'mo_ta',
        'image',
        'gia',
        'thumbnail',
        'trang_thai',
        'created_by'
    ];

    protected $attributes = [
        'image' => null,
        'gia' => 0,
        'trang_thai' => 'active'
    ];

    public function baiHocs()
    {
        return $this->hasMany(BaiHoc::class, 'id_khoahoc');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}