<?php

namespace App\Services;

use App\Models\Order;

class PaymentService
{
    public function createSslPaymentSession(Order $order): string
    {
        // THIS IS A PLACEHOLDER FOR SSLCOMMERZ INTEGRATION
        // Later, we will use an SDK or curl to hit SSLCommerz init API.
        
        // For now, simulate a redirect URL dynamically:
        return route('payment.success', ['order_id' => $order->id]);
    }
}
