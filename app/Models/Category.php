<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'parent_id',// Đây là một danh mục cấp cao nhất nên không có danh mục cha
    ];
    // Đây là một phương thức để thiết lập mối quan hệ "belongsTo" giữa các bảng. 
    // Nó cho biết rằng mỗi danh mục có thể có một danh mục cha. 
    // Tham số đầu tiên là tên của model liên quan và tham số thứ hai là tên cột ngoại khóa trong bảng hiện tại.
    public function parent(){
        return $this->belongsTo(Category::class ,'parent_id');
    }
    // Đây là một phương thức để thiết lập mối quan hệ "hasMany" giữa các bảng. 
    // Nó cho biết rằng mỗi danh mục có thể có nhiều danh mục con. 
    // Tham số đầu tiên là tên của model liên quan và tham số thứ hai là tên cột ngoại khóa trong bảng hiện tại.
    public function childrents(){
         return $this->hasMany(Category::class,'parent_id');

    }
    // Đây là một trường ảo (accessor) để trả về tên của danh mục cha. 
    // Điều này cho phép bạn truy cập vào trường parent_name như một thuộc tính thông thường trên đối tượng Category, 
    // mặc dù không có trường parent_name trong bảng cơ sở dữ liệu.
    public function getParentNameAttribute(){
        return optional($this->parent)->name;
    }

    public function getParents(){
        return Category::whereNull('parent_id')->with('childrents')->get(['id','name']);
    }
}
