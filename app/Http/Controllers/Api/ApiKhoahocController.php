<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\KhoaHoc;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class ApiKhoahocController extends Controller
{
    public function index()
    {
        $khoaHocs = KhoaHoc::all();

        return response()->json([
            'data' => $khoaHocs,
        ]);
    }
}