<?php

namespace App\Models;

use App\Traits\HandleUploadImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory ,HandleUploadImageTrait;
    protected $fillable = [
        'name',
        'description',
        'sale',
        'price',
    ];

    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function assignCategory($categoriyIds){
        return $this->categories()->sync($categoriyIds);
    }
    public function getBy($dataSearch, $categoryId)
    {
        return $this->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        })->paginate(10);
    }
    // public function getImagePathAtribute(){
    //     return asset($this->images->count() > 0 ? 'upload/'.$this->images->first()->url:'upload/default.jpg');
        
    // }
    public function getImagePathAttribute()
{
    return asset($this->images->count() > 0 ? 'upload/'.$this->images->first()->url : 'upload/default.jpg');
}

    public function getSalePriceAttribute(){
        //giá hiện tại trừ đi giá sale nhân vơi 0,01 giá gốc 
        //mặc định sẽ là 0
        return $this->attributes['sale'] ? $this->attributes['price']- ($this->attributes['sale']*0.01 * $this->attributes['price']) :0;
    }
    public function deleteImage($imageUrl)
    {
        // Xóa hình ảnh từ thư mục
        if (file_exists(public_path($imageUrl))) {
            unlink(public_path($imageUrl));
        }
    }
}
