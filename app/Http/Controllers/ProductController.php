<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $name = $request->name ?? 0;
        $priceMin = $request->priceMin ?? 0;
        $priceMax = $request->priceMin ?? 0;
        $is_sales = $request->is_sales ?? 0;
        $search_active = $request->is_active ?? 2;
        $product = Product::orderBy('created_at', 'desc')->where('is_delete', 1);
        // if($search_active!=2){
        //     $product=$product->where('is_active',$is_sales);
        // }
        if (!empty($name)) {
            $product = $product->where('name', 'like', "%$name%");
        }
        $paginate = $product->paginate($perPage);
        $paginate->getCollection()->transform(function ($product) {

            if ($product->is_sales == 0) {
                $product->sales_text = 'Ngừng Bán';
            } else if ($product->is_sales == 1) {
                $product->sales_text = 'Đang bán';
            } else if ($product->is_sales == 2) {
                $product->sales_text = 'Hết Hàng';
            }
            return $product;
        });
        if ($request->ajax()) {
            return response()->json([$paginate], 201);
        }
        return view('product_pm');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('add_product');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = $request->validate([
            'name' => 'required|min:5',
            'price' => 'required|numeric|min:0',
            'is_sales' => 'required',
            'img'=>'mimes:png,jpg,jpeg|max:2000'
        ], [
            'required' => ':attribute không được để trống',
            'name.min'=>':attribute không được bé hơn 5',
            'price.min'=>':attribute không được bé hơn 0',
            'unique' => ':attribute không được trùng',
            'email' => ':attribute phải là định dạng email',
            'numeric' => ':attribute phải là số',
            'mimes'=>':attribute phải là file ảnh đuôi .png,.jpg.jpeg',
            'max'=>':attribute không được lớn hơn 2mb'
        ], [
            'name' => 'Tên sản phẩm',
            'price' => 'Giá bán',
            'is_sales' => 'Tình trạng',
            'img'=>'File',
        ],

    );
        if (!empty($input['img'])) {
            $file = $request->file('img');
            $fileDestinationPath = "products";
            if ($file->move($fileDestinationPath, $file->getClientOriginalName())) {
                $input['img'] = $fileDestinationPath . '/' . $file->getClientOriginalName();
            } else {
                $arr = [
                    'success' => false,
                    'message' => 'Lỗi kiểm tra dữ liệu',
                ];
                return response()->json($arr, 200);
            }
        }
        $product = Product::create($input);
        // if ($request->ajax()) {
        //     return view('product_pm');
        // }

        // return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product=Product::find($id);
        return view('update_product',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $product = Product::find($id);

        $product->is_delete = 0;
        $product->save();
        return response()->json(['success' => 'Xóa thành công'], 201);
    }
}
