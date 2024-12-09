<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CreditCard;
use Illuminate\Http\Request;

class CreditCardController extends Controller
{
    // Hiển thị danh sách thẻ tín dụng
    public function index()
    {
        // Lấy tất cả thẻ tín dụng từ cơ sở dữ liệu
        $creditCards = CreditCard::all();

        // Trả về danh sách thẻ tín dụng dưới dạng JSON
        return response()->json($creditCards);
    }

    // Tạo thẻ tín dụng mới
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id', // Kiểm tra user_id tồn tại trong bảng users
            'card_number' => 'required|string|max:16',
            'card_holder_name' => 'required|string|max:255',
            'cvv' => 'required|string|max:3',
        ]);

        // Tạo thẻ tín dụng mới
        $creditCard = CreditCard::create([
            'user_id' => $validated['user_id'],
            'card_number' => $validated['card_number'],
            'card_holder_name' => $validated['card_holder_name'],
            'cvv' => $validated['cvv'],
        ]);

        // Trả về thông tin thẻ tín dụng vừa tạo dưới dạng JSON
        return response()->json($creditCard, 201);
    }

    // Xóa thẻ tín dụng (có thể dùng route khác nếu cần)
    public function destroy($id)
    {
        $creditCard = CreditCard::find($id);

        if (!$creditCard) {
            return response()->json(['message' => 'Credit card not found'], 404);
        }

        // Xóa thẻ tín dụng
        $creditCard->delete();

        return response()->json(['message' => 'Credit card deleted successfully']);
    }
}
