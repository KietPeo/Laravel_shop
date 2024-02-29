<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected $user;
    protected $role;

    public function __construct(User $user,Role $role){
        $this->user = $user;
        $this->role = $role;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users=$this->user->latest('id')->paginate(5);
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles= $this->role->all()->groupBy('group');
        return view ('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        // echo ('aaaaa');
        //
        // dd($request->all());
        $dataCreate=$request->all();
        //cần phải mã hóa password bằng Hash
        $dataCreate['password']=Hash::make($request->password);
        $dataCreate['image']=$this->user->saveImage($request);
        $user=$this->user->create($dataCreate);
        $user->images()->create(['url'=>$dataCreate['image']]);
        //thiet lap quan he
        $user->roles()->attach($dataCreate['role_ids']);
        return to_route('users.index')->with(['message'=>'create success']);
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
    $user = $this->user->findOrFail($id)->load('roles');
    $roles = Role::all()->groupBy('group');
    return view('admin.users.edit', compact('user', 'roles'));
}

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateUserRequest $request, string $id)
    // {
    //     //

    //      // dd($request->all());
    //      $dataUpdate=$request->except('password');
    //      $user = $this->user->findOrFail($id)->load('roles');

    //      if ($request->password) {
    //         # code...
    //         $dataUpdate['password']=Hash::make($request->password);
    //      }
    //      $currentImage=$user->images?$user->images->first()->url :'';
    //      $dataUpdate['image']=$this->user->updateImage($request,$currentImage);
    //      $user->update($dataUpdate);
    //      $user->images()->delete();
    //      $user->images()->updateOrcreate(['url'=>$dataUpdate['image']]);


         
    //      //thiet lap quan he
    //      $user->roles()->sync($dataUpdate['role_ids']??[]);
    //      return to_route('users.index')->with(['message'=>'Edit success']);

    // }
//     public function update(UpdateUserRequest $request, string $id)
// {
//     // Find the user by ID
//     $user = $this->user->findOrFail($id)->load('roles');

//     // Validate the request and update the user
//     $dataUpdate = $request->except('password');

//     // Check if password is provided and hash it
//     if ($request->password) {
//         $dataUpdate['password'] = Hash::make($request->password);
//     }

//     // Check if the user has associated images
//     if ($user->images()->exists()) {
//         // Get the current image URL
//         $currentImage = $user->images->first()->url;

//         // Update the image if a new image is provided
//         $dataUpdate['image'] = $this->user->updateImage($request, $currentImage);

//         // Delete the existing image
//         $user->images()->delete();

//         // Update or create the image record
//         $user->images()->updateOrCreate(['url' => $dataUpdate['image']]);
//     }

//     // Update the user
//     $user->update($dataUpdate);

//     // Sync user roles
//     $user->roles()->sync($dataUpdate['role_ids'] ?? []);

//     return redirect()->route('users.index')->with('message', 'Edit success');
// }
public function update(UpdateUserRequest $request, string $id)
{
    // Tìm người dùng theo ID
    $user = $this->user->findOrFail($id)->load('roles');

    // Validate the request and update the user
    $dataUpdate = $request->except('password');

    // Kiểm tra xem có cung cấp mật khẩu không và mã hóa nó
    if ($request->password) {
        $dataUpdate['password'] = Hash::make($request->password);
    }

    // // Kiểm tra xem người dùng có ảnh không
    // if ($request->hasFile('image')) {
    //     // Lưu ảnh mới và cập nhật URL trong cơ sở dữ liệu
    //     $dataUpdate['image'] = $this->user->saveImage($request);
    // }
    $currentImage = $user->images->isNotEmpty() ? $user->images->first()->url : null;
    $dataUpdate['image']=$this->user->updateImage($request,$currentImage);

    $user->update($dataUpdate);
    $user->images()->delete();
    $user->images()->updateOrcreate(['url'=>$dataUpdate['image']]);

    // Cập nhật người dùng
    $user->update($dataUpdate);

    // Đồng bộ các vai trò của người dùng
    $user->roles()->sync($dataUpdate['role_ids'] ?? []);

    return redirect()->route('users.index')->with('message', 'Cập nhật thành công');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = $this->user->findOrFail($id)->load('roles');
        $user->delete();
        $currentImage=$user->images->count() > 0 ?$user->images->first()->url :'';
        $this->user->dateleImage( $currentImage);
        $user->images()->delete();
        return to_route('users.index')->with(['message'=>'Delete success']);

    }
}
