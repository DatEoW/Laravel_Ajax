<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;

        $name = $request->name ?? null;
        $priceMin = $request->priceMin ?? 0;
        $priceMax = $request->priceMax ?? 0;
        $temp = 0;
        $is_sales = $request->is_sales ?? 3;

        $product = Product::orderBy('created_at', 'desc')->where('is_delete', 1);

        if ($name != null) {
            $product = $product->where('name', 'like', "%$name%");
        }
        if ($is_sales != 3) {
            $product = $product->where('is_sales',  $is_sales);
        }
        if ($priceMin != 0 && $priceMax != 0) {
            if ($priceMin > $priceMax) {
                $priceMin = $temp;
                $priceMax = $priceMin;
                $priceMin = $temp;
            } else if ($priceMin < 0 || $priceMax < 0) {
                return response()->json(['mess' => 'Giá tiền không được là số âm'], 201);
            }
            $product->whereBetween('price', [$priceMin, $priceMax]);
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
        try {
            $this->authorize('create', Product::class);
            return view('add_product');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 403);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->authorize('create', Product::class);
            $input = $request->all();
            // dd($input);
            $validator = $request->validate(
                [
                    'name' => 'required|min:5',
                    'price' => 'required|numeric|min:0',
                    'is_sales' => 'required',
                    'img' => 'mimes:png,jpg,jpeg|max:2000'
                ],
                [
                    'required' => ':attribute không được để trống',
                    'name.min' => ':attribute không được bé hơn 5',
                    'price.min' => ':attribute không được bé hơn 0',
                    'unique' => ':attribute không được trùng',
                    'email' => ':attribute phải là định dạng email',
                    'numeric' => ':attribute phải là số',
                    'mimes' => ':attribute phải là file ảnh đuôi .png,.jpg.jpeg',
                    'max' => ':attribute không được lớn hơn 2mb',
                    //

                ],
                [
                    'name' => 'Tên sản phẩm',
                    'price' => 'Giá bán',
                    'is_sales' => 'Tình trạng',
                    'img' => 'File',
                ],

            );
            if (!empty($input['img'])) {
                $file = $request->file('img');
                $fileName = $file->hashName();
                $extension = $file->extension();
                $absolutePath = 'storage/fake_images/' . $fileName;
                $input['img'] = $absolutePath;
                $path = Storage::putFileAs('/public/fake_images', $file, $fileName);
            }
            if(ctype_digit(mb_substr($input['name'], 0, 1, 'UTF-8'))){
                $error='Ký tự đầu tiên phải là chữ';
                return response()->json(['error' => $error], 422);
            }else{
                $product = Product::create($input);
                return redirect()->route('product.index');
            }


        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 403);
        }
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
        try {
            $this->authorize('update', Product::class);
            $product = Product::find($id);
            return view('update_product', compact('product'));
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $this->authorize('update', Product::class);
            $input = $request->all();

            $validator = $request->validate(
                [
                    'name' => 'required|min:5',
                    'price' => 'required|numeric|min:0',
                    'is_sales' => 'required',
                    'img' => 'mimes:png,jpg,jpeg|max:2000'
                ],
                [
                    'required' => ':attribute không được để trống',
                    'name.min' => ':attribute không được bé hơn 5',
                    'price.min' => ':attribute không được bé hơn 0',
                    'unique' => ':attribute không được trùng',
                    'email' => ':attribute phải là định dạng email',
                    'numeric' => ':attribute phải là số',
                    'mimes' => ':attribute phải là file ảnh đuôi .png,.jpg.jpeg',
                    'max' => ':attribute không được lớn hơn 2mb'
                ],
                [
                    'name' => 'Tên sản phẩm',
                    'price' => 'Giá bán',
                    'is_sales' => 'Tình trạng',
                    'img' => 'File',
                ],

            );
            if (!empty($input['img'])) {
                $file = $request->file('img');
                $fileName = $file->hashName();
                $extension = $file->extension();
                $absolutePath = 'storage/fake_images/' . $fileName;
                $input['img'] = $absolutePath;
                $path = Storage::putFileAs('/public/fake_images', $file, $fileName);
            }
            if(ctype_digit(mb_substr($input['name'], 0, 1, 'UTF-8'))){
                $error='Ký tự đầu tiên phải là chữ';
                return response()->json(['error' => $error], 422);
            }else{
                $product = Product::find($input['id'])->update($input);
                return redirect()->route('product.index');
            }


        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $this->authorize('delete', Product::class);
            $product = Product::find($id);

        $product->is_delete = 0;
        $product->save();
        return response()->json(['success' => 'Xóa thành công'], 201);
        }catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $errorMessage = $e->getMessage();
            return response()->json(['error' => $errorMessage], 403);
        }

    }
}
