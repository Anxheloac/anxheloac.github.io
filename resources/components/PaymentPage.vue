
<template>
<div>
<div id="dropin-container"></div>
 <button class="px-3 py-1 bg-red-500 text-white text-sm font-semibold rounded" id="submit-button">
	 Pay now
</button>
</div>
</template>

<script>
import braintreeDropIn from 'braintree-web-drop-in'
import axios from "axios"

export default {
	name: 'payment-page',
	props : ['order', 'purchaseUrl'],
	mounted(){
		console.log(this.purchaseUrl)
		this.initBraintreeForm();
	},
	methods:{
		initBraintreeForm(){

			var app = this
			var purchaseUrl = this.purchaseUrl;
			var orderId = this.order.id;

			braintreeDropIn.create({
		      authorization: 'sandbox_fwzmmfc3_3nq8qjnmxpygth2p',
		      container: '#dropin-container',
			   paypal: {
					flow: 'vault'
				}
		    }, function (createErr, instance) {
			  
		      document.getElementById("submit-button").addEventListener('click', function () {
					instance.requestPaymentMethod(function (err, payload) {
						  if(payload.nonce != undefined){
							axios({
								method: "post",
								url: purchaseUrl,
								data: {
									order_id: orderId,
									payment_method_nonce: payload.nonce
								}
							}).then(response => {
								 app.$alert(response.message)
							});
						  }
					});
				})
		    });
		}
	}
}

</script>