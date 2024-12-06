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
        'video',
        'id_khoahoc',
    ];
}