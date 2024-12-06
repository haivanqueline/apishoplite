<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CreditCardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            $cards = CreditCard::where('user_id', Auth::id())
                            ->where('status', 'active')
                            ->get();

            return response()->json([
                'status' => true,
                'data' => $cards
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể lấy danh sách thẻ',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'required|string|size:16',
            'card_holder_name' => 'required|string|max:255',
            'expiration_month' => 'required|string|size:2',
            'expiration_year' => 'required|string|size:4',
            'cvv' => 'required|string|size:3',
            'card_type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi xác thực',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            $data['user_id'] = Auth::id();
            
            // Nếu là thẻ đầu tiên, đặt làm mặc định
            if (CreditCard::where('user_id', Auth::id())->count() === 0) {
                $data['is_default'] = true;
            }

            $card = CreditCard::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Thêm thẻ thành công',
                'data' => $card
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể thêm thẻ',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function setDefault($id)
    {
        try {
            $card = CreditCard::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->first();

            if (!$card) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy thẻ'
                ], 404);
            }

            // Bỏ mặc định tất cả thẻ khác
            CreditCard::where('user_id', Auth::id())
                    ->update(['is_default' => false]);

            // Đặt thẻ hiện tại làm mặc định
            $card->is_default = true;
            $card->save();

            return response()->json([
                'status' => true,
                'message' => 'Đặt thẻ mặc định thành công'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể đặt thẻ mặc định',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $card = CreditCard::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->first();

            if (!$card) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy thẻ'
                ], 404);
            }

            // Nếu xóa thẻ mặc định, đặt thẻ khác làm mặc định
            if ($card->is_default) {
                $newDefaultCard = CreditCard::where('user_id', Auth::id())
                                        ->where('id', '!=', $id)
                                        ->first();
                if ($newDefaultCard) {
                    $newDefaultCard->is_default = true;
                    $newDefaultCard->save();
                }
            }

            $card->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xóa thẻ thành công'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể xóa thẻ',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}