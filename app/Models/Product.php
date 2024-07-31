<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'id',
        'name',
        'price',
        'quantity',
        'image',
        'category_id',
        'status',
        'created_at',
        'updated_at'
    ];
    public $timestamps = false;
    public function loadAllCategory(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function loadDataWithPager(){
        // Chưa có tìm kiếm
        // Có truy vân kèm phân trang
        // ORM
        $query = Product::query()
                ->with('loadAllCategory')
                ->latest('id')
                ->paginate(10);
        // DB
        // Join
//        $this->fillable[] = 'categories.name as catename';
//        $query = DB::table($this->table)
//            ->select($this->fillable)
//            ->join('categories', 'products.category_id', '=', 'categories.id')
//            ->orderByDesc('id')
//            ->paginate(10);
        // Truy vân + logic
//        $query = DB::table($this->table)
//            ->select($this->fillable)
//            ->orderByDesc('id')
//            ->paginate(10);
        return $query;
    }
    public function insertDataProduct($params){
        $params['status'] = 1;
        $params['created_at'] = date('Y-m-d H:i:s');
        $res = Product::query()->create($params);
        return $res;
    }
    public function getDataProductById($id){
        $query = Product::query()
            ->with('loadAllCategory')
            ->find($id);
        return $query;
    }
    public function updateDataProduc($params, $id){
        $params['updated_at'] = date('Y-m-d H:i:s');
       $res =  Product::query()
           ->find($id)
           ->update($params);
       return $res;
    }
    public function deleteDataProduct($id){
        $res = Product::query()->find($id)->delete();
        return $res;
    }
}
