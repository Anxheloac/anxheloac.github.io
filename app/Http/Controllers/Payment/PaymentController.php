<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentRequest;
use AvoRed\Framework\Database\Models\Order;
use AvoRed\Framework\Database\Contracts\OrderModelInterface;
use App\Services\BraintreeService;
use App\Services\OrderService;

class PaymentController extends Controller
{
    /**
     * @var \AvoRed\Framework\Database\Repository\OrderRepository
     */
    protected $oderRepository;

    /**
     * 
     */
    protected $braintreeService;

    /**
     * 
     */
    protected $orderService;

    /** 
     * 
     */
    public function __construct(
        OrderModelInterface $orderRepository,
        BraintreeService $braintreeService,
        OrderService $orderService
    ){
        $this->orderRepository = $orderRepository;
        $this->braintreeService = $braintreeService;
        $this->orderService = $orderService;
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
        $totalAmount = $this->orderService->computeTotalAmount($order);

        $result = $this->braintreeService->purchase( $totalAmount, $request->payment_method_nonce);
        
        \Log::info( ' braintree result' .$result);

        if ($result->success) {
            \Log::error("success!: " . $result->transaction->id);
            Transaction::create([
                'order_id' => $order->id,
                'transaction_id' => $result->transaction->id,
                'status' => $result->transaction->status,
            ]);
        } else if ($result->transaction) {
            throw new \Exception('Error processing transaction', 500);
            \Log::error("Error processing transaction:");
            \Log::error("\n  code: " . $result->transaction->processorResponseCode);
            \Log::error("\n  text: " . $result->transaction->processorResponseText);
        } else {
            \Log::error("Validation errors: \n");
            \Log::error($result->errors->deepAll());
            throw new \Exception('Payment error', 500);
        }
        //send payment to braintree
        $order->update(['order_status_id' => 2]);

        return response()->json(['message' => 'Payment done']);
    }
}
