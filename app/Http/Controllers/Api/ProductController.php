<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAllProductList()
    {
        // $products = \App\Models\Product::where('status', 'active')->get();
        $products = \DB::select('select a.id, a.title, a.photo, a.price from products a where status = "active"');
        return response()->json([
            'success' => true,
            'products' => json_encode($products),
        ], 200);
    }
    public function getAllCat(){
        $cats = \App\Models\Category::where('status','active')->get();
        return response()->json([
            'success' => true,
            'cats' => json_encode($cats),
        ], 200);
    }
    public function getProductCat(Request $request){
        $id = $request->cat_id;
        $products = \App\Models\Product::where('cat_id',$id)-> where('status','alive')->get();
        return response()->json([
            'success' => true,
            'products' => json_encode($products),
        ], 200);
    }
}
