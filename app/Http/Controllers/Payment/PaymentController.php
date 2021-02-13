<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentRequest;
use AvoRed\Framework\Database\Models\Order;
use AvoRed\Framework\Database\Contracts\OrderModelInterface;

class PaymentController extends Controller
{
    /**
     * @var \AvoRed\Framework\Database\Repository\OrderRepository
     */
    protected $oderRepository;

    /** 
     * 
     */
    public function __construct(
        OrderModelInterface $orderRepository
    ){
        $this->orderRepository = $orderRepository;
    }

    /** 
     * show payment form
     */
    public function showForm()
    {
    	$order = json_encode(['id' => 3]);
    	return view('checkout.payment', compact('order'));
    }


    /** 
     * Make the payment of order
     */
    public function pay(PaymentRequest $request){
        $order = Order::find($request->order_id);
        //send payment to braintree
        $order->update(['order_status_id' => 2]);

        return response()->json(['message' => 'Payment done']);
    }
}
