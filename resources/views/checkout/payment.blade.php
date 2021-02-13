@extends('layouts.app')

@section('breadcrumb')
<div class="bg-gray-200 p-3 rounded text-sm mb-5">
    <ol class="list-reset flex text-gray-700">
      <li>
          <a class=" font-semibold" href="{{ route('home') }}">
              {{ __('avored.home') }}
          </a>&nbsp; > &nbsp;
      </li>
       <li>
          <span class="">
              {{ __('avored.checkout') }}
          </span>
        </li>
    </ol>
</div>
@endsection


@section('content')
  
  <payment-page :order="{{ $order }}" :purchase-url="'{{ route('payment.make_purchase') }}'"></payment-page>
    
@endsection