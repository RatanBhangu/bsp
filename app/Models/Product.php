<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'products';
    protected $fillable = ['name','description','price','quantity'];
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dateFormat = 'U';

    public static function getAllProduct(){
        return Product::orderBy('id','desc')->paginate(10);
    }

    public static function getProductById($id){
        return Product::where('id',$id)->first();
    }

    public static function countProduct(){
        $data=Product::count();
        if($data){
            return $data;
        }
        return 0;
    }
}
