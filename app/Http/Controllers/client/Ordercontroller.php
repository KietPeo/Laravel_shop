<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Oder;
use App\Models\User;
use Illuminate\Http\Request;

class Ordercontroller extends Controller
{
    //

    protected $order;
    protected $user;
    public function __construct(Oder $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }
    public function index()
    {
        $orders = $this->order->getWithPaginate(auth()->user()->id);
        // return view('client.oders.index',compact('orders'));
        return view('client2.oders.index', compact('orders'));
        // $id = auth()->id(); // Get the authenticated user's ID
        // $user = $this->user->findOrFail($id);
        // // dd($user->id); 
        // $orders=$this->order->getWithPaginate($user);
        // return view('client2.oders.index',compact('orders'));


    }
    public function cancel($id)
    {
        $order = $this->order->findOrFail($id);
        $order->update(['status' => 'cancelled']);

        // Retrieve orders again after updating
        $orders = $this->order->getWithPaginate(auth()->user()->id);

        return back()->with('message', 'Hủy Thành Công');
    }
}
