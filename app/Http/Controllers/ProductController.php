<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
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
     * Show dữ liệu product, search ,sort theo các input : name,email,priceMin,PriceMax
     * các function query được hỗ trợ với Scope và mutator
     * @param  $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $perPage = $request->perPage ?? 10;
        $name = $request->name ;
        $priceMin = $request->priceMin;
        $priceMax = $request->priceMax ;
        $is_sales = $request->is_sales;
        $product = Product::orderBy('created_at', 'desc')->where('is_delete', 0);
        $product->byName($name);
        $product->byStatus($is_sales);
        $product->byPrice($priceMin,$priceMax);
        $paginate = $product->paginate($perPage);
        $paginate->getCollection()->transform(function ($product) {

           $product->getSalesTextAttribute();
           return $product;
        });
        if ($request->ajax()) {
            return response()->json([$paginate], 201);
        }
        return view('product_pm');
    }

      /**
     * Chuyển sang trang thêm sản phẩm
     *
     *  @return \Illuminate\View\View
     */
    public function create()
    {

            $this->authorize('create', Product::class);
            return view('add_product');

    }


       /**
     * Thêm product
     * @param  $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function store(ProductRequest $request)
    {
        try {
            $this->authorize('create', Product::class);

            $input = $request->all();
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
     * Chuyển sang trang chỉnh sửa sản phẩm
     *  @param string $id
     *  @return \Illuminate\View\View
     */
    public function edit(string $id)
    {

            $this->authorize('update', Product::class);
            $product = Product::find($id);
            return view('update_product', compact('product'));

    }

        /**
     * Thực hiện chỉnh sửa Product
     * @param  $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function update(ProductRequest $request)
    {
        try {
            $this->authorize('update', Product::class);
            $input = $request->all();
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
     * Xóa product
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse|void
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
