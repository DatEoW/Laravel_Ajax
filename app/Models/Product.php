<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $table='mst_products';
    protected $primaryKey='id';

     /**
     * cho phép id khóa chính type string
     *
     */
    protected $keyType='string';
    protected $fillable = [
        'name',
        'describe',
        'password',
        'price',
        'is_sales',
        'is_delete',
        'img',

    ];
    const DANGBAN =1;
    const HETHANG=2;
    const NGUNGBAN=0;
    const NOSEARCHSALES=3;
    const DELETED=1;
    const NOTDELETE=0;

     /**
     * Xử lý ký tự đặc biệt với Helper Str
     * @param  number
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $lastProductId = DB::table('mst_products')
            ->orderByRaw("CAST(SUBSTRING(id, 2) AS UNSIGNED) DESC")
            ->first();

            $intId = 0;

            if (!empty($lastProductId)) {
                $intId = (int)substr($lastProductId->id, 1, 9);
            }
            //xử lý ký tự đặc biệt
            $firstChar=Str::charAt($product->name,0);
            $unaccentedChar=strtoupper(Str::slug($firstChar));
            Log::info($firstChar);
            Log::info($unaccentedChar);

            $product->id = $unaccentedChar . str_pad($intId + 1, 9, '0', STR_PAD_LEFT);
        });
        static::updating(function ($product) {


            $idOld=$product->id;
            $firstChar=Str::charAt($product->name,0);
            $unaccentedChar=strtoupper(Str::slug($firstChar));
            Log::info($firstChar);
            Log::info($unaccentedChar);

            $product->id = substr_replace($idOld, $unaccentedChar, 0, 1);
        });


    }
    protected $appends=['sales_text'];
    public function getSalesTextAttribute()
    {
        $sales_text = '';

        if ($this->is_sales == Product::NGUNGBAN) {
            $sales_text = '<p class="text-danger fw-bold">Ngừng Bán</p>';
        } else if ($this->is_sales == Product::DANGBAN) {
            $sales_text = '<p class="text-success">Đang bán</p>';
        } else if ($this->is_sales == Product::HETHANG) {
            $sales_text = '<p class="text-warning">Hết Hàng</p>';
        }
        return $sales_text;
    }
    public function scopeByName( $query,$name=''): void
    {
        if (!empty($name)||$name==0) {
             $query->where('name', 'like', "%$name%");
        }

    }
    public function scopeByStatus( $query,$is_sales= Product::NOSEARCHSALES): void
    {
        if (isset($is_sales)&& $is_sales != Product::NOSEARCHSALES) {
            $query->where('is_sales', $is_sales);
        }

    }
    public function scopeByPrice($query,$priceMin=0,$priceMax=0): void
    {
        if(isset($priceMin)||isset($priceMax)){
            if(isset($priceMin) && !isset($priceMax)){
                $query->where('price','>=',$priceMin)->getQuery()->orders = [];
                $query->orderBy('price','asc');
            }else if(!isset($priceMin)&&isset($priceMax)){
                $query->where('price','<',$priceMax)->getQuery()->orders = [];
                $query->orderBy('price','desc')->toSql();
            }else{
                $query->whereBetween('price',[$priceMin,$priceMax])->getQuery()->orders = [];
                $query->orderBy('price','asc');
            }

        }

    }



}
