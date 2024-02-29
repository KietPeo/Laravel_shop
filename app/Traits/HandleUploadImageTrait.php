<?php
namespace App\Traits;

use App\Models\Image as ModelsImage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait HandleUploadImageTrait
{
    protected $path='upload/';
    public function verify($request){
        return $request->has('image');

    }
    public function saveImage($request){
        if ($this->verify($request)) {
            # code...
            $image=$request->file('image');
            $name=time().'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save($this->path.$name);
            return $name;
        }
    }
    public function updateImage($request,$currentImage){
        if ($this->verify($request)) {
            # code...
            $this->delete($currentImage);
            return $this->saveImage($request);
        }
        return $currentImage;
    }
    public function dateleImage($imageName){
        if ($imageName && file_exists($this->path.$imageName)) {
            # code...
            unlink($this->path.$imageName);
        }
    }
}
;