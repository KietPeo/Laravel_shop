<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MyProfile extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $user;


    public function __construct(User $user){
        $this->user = $user;

    }
    public function index()
    {
        //
        $user = auth()->user();
        return view('client2.setting.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, string $id)
    {
        // Tìm người dùng bằng ID
        // Tìm người dùng bằng ID
        $user = $this->user->findOrFail($id);

        // Validate the request and update the user
        $dataUpdate = $request->except('password');
       
    
        $user->update($dataUpdate);
   
        // Chuyển hướng về trang profile.index và gửi thông báo thành công
        return back()->with('message', 'Cập Nhật Thành Công ');
        
    }
//     public function updatePassword(Request $request, string $id)
// {
//     // Kiểm tra xem người dùng đã nhập mật khẩu mới hay không
//     // if ($request->filled('password')) {
//     //     // Lấy dữ liệu từ request
//     //     $data = $request->only('password');

//     //     // Mã hóa mật khẩu mới bằng Hash
//     //     $data['password'] = Hash::make($data['password']);

//     //     // Cập nhật mật khẩu mới vào database
//     //     $user = User::findOrFail($id);
//     //     $user->update($data);

//     //     // Redirect về trang cập nhật và gửi thông báo thành công
//     //     return back()->with('message', 'Cập Nhật Mật Khẩu Thành Công');
//     // } else {
//     //     // Nếu người dùng không nhập mật khẩu mới, trả về trang trước và thông báo lỗi
//     //     return back()->with('error', 'Mật Khẩu Chưa Nhập');
//     // }
//     if ($request->password) {
//         # code...
//         if ($request->newpassword) {
//             # code...
//             $user = $this->user->findOrFail($id);
//             // Lấy dữ liệu từ request
//             $data['password'] = Hash::make($request->newpassword);
//             // Cập nhật mật khẩu mới vào database
//             $user->update($data);
//             return back()->with('message', 'Mật Khẩu Được Cập Nhật');
//         }else{
//             return back()->with('message', 'Mật Khẩu Mới Chưa Nhập');
//         }

//     }else{
//         return back()->with('message', 'Mật Khẩu Cũ Được Cập Nhật');
//     }
//     // dd($request->newpassword);
// }
public function updatePassword(Request $request, string $id)
{
    $user = $this->user->findOrFail($id);

    // Kiểm tra xem mật khẩu cũ đã được nhập đúng hay không
    if (!Hash::check($request->password, $user->password)) {
        // Nếu mật khẩu cũ không chính xác, trả về thông báo lỗi
        return back()->with('message', 'Mật Khẩu Cũ Không Chính Xác');
    }

    // Kiểm tra xem người dùng đã nhập mật khẩu mới hay không
    if (!$request->filled('newpassword')) {
        // Nếu mật khẩu mới không được nhập, trả về thông báo lỗi
        return back()->with('message', 'Mật Khẩu Mới Chưa Nhập');
    }

    // Lấy dữ liệu từ request
    $data['password'] = Hash::make($request->newpassword);

    // Cập nhật mật khẩu mới vào database
    $user->update($data);

    // Redirect về trang cập nhật và gửi thông báo thành công
    return back()->with('message', 'Mật Khẩu Được Cập Nhật');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
