<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Oder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    protected $order;

    public function __construct(Oder $order)
    {
        $this->order = $order;
    }

    public function index()
    {

        $orders = $this->order->getWithPaginate(auth()->user()->id);
        return view('admin.orders.index', compact('orders'));
    }

    // public function updateStatus(Request $request, $id)
    // {

    //     $order = $this->order->findOrFail($id);
    //     $order->update(['status' => $request->status]);

    //     return response()->json(['message' => 'success'], Response::HTTP_OK);
    // }
    public function updateStatus(Request $request, $id)
    {
        // Lấy đối tượng order cần cập nhật trạng thái
        $order = $this->order->findOrFail($id);

        // Cập nhật trạng thái từ dữ liệu gửi đi từ request
        $order->update(['status' => $request->status]);

        // Trả về kết quả thành công
        return redirect()->back()->with('status', 'Trạng thái đã được cập nhật thành công');
    }
}
