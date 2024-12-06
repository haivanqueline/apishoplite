<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\BaiHoc;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class ApiBaihocController extends Controller
{
    public function index()
    {
        $baiHocs = BaiHoc::all();

        return response()->json([
            'data' => $baiHocs,
        ]);
    }
}