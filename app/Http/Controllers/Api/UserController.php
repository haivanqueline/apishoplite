<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $pagesize;

    public function __construct()
    {
        $this->pagesize = env('NUMBER_PER_PAGE', '20');
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            $users = User::where('status', 'active')
                        ->orderBy('id', 'DESC')
                        ->paginate($this->pagesize);

            return response()->json([
                'status' => true,
                'data' => $users,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch users',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('q');
            
            $users = User::where('status', 'active')
                        ->where(function($q) use ($query) {
                            $q->where('full_name', 'LIKE', "%{$query}%")
                              ->orWhere('email', 'LIKE', "%{$query}%")
                              ->orWhere('phone', 'LIKE', "%{$query}%");
                        })
                        ->orderBy('id', 'DESC')
                        ->paginate($this->pagesize);

            return response()->json([
                'status' => true,
                'data' => $users,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to search users',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // public function index(): JsonResponse
    // {
    //     $users = User::where('id', '!=', auth()->user()->id)->get();
    //     return $this->success($users);
    // }
}