<?php

function stripe_pay()
{
    require_once('vendor/autoload.php');

    $stripe = new \Stripe\StripeClient('sk_test_hm2Yenyg0uvS1oBaRgxC1P9H000oMLdZFH');

    try {
        $stripeCheckout = $stripe->checkout->sessions->create([
            'success_url' => 'https://gadgetmedics.chaly.xyz/success.php?name=test',
            'cancel_url' => 'https://gadgetmedics.chaly.xyz/cancel.php',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'product_data' => [
                        'name' => "iPhone Back Glass Repair",
                        'metadata' => [
                            'pro_id' => "12"
                        ]
                    ],
                    'unit_amount' => 75,
                    'currency' => "usd",
                ],
                'quantity' => 1,
                'description' => "test description",
            ]],
            'mode' => 'payment',
        ]);
        echo "
     <script>
 var stripe = Stripe('pk_test_Eka8NnaCTGmaEWpHyIMKX0p500qc3MUTKh');
 stripe.redirectToCheckout({
 sessionId: '$stripeCheckout->id'
 }).then(function (result) {
  result.error.message
 });
 </script>
 ";
    } catch (\Stripe\Exception\ApiErrorException $e) {
        echo $e->getMessage();
    }

}


if ($_GET['test'] == 'test1'){
    echo "all ok";
}