<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiHoc extends Model
{
    use HasFactory;

    protected $table = 'bai_hocs';

    protected $fillable = [
        'ten_bai_hoc',
        'mo_ta',
        'id_khoahoc',
        'video',
        'noi_dung',
        'tai_lieu',
        'thu_tu',
        'thoi_luong',
        'trang_thai',
        'luot_xem'
    ];

    public function khoaHoc()
    {
        return $this->belongsTo(KhoaHoc::class, 'id_khoahoc');
    }
}