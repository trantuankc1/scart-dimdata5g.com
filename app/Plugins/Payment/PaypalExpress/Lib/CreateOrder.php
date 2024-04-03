<?php

namespace App\Plugins\Payment\PaypalExpress\Lib;

use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class CreateOrder
{
    /**
     * This is the sample function which can be sued to create an order. It uses the
     * JSON body returned by buildRequestBody() to create an new Order.
     */
    public static function createOrder($body, $debug=false)
    {
        $request = new OrdersCreateRequest();
        $request->headers["prefer"] = "return=representation";
        $request->body = $body;

        $client = PayPalClient::client();
        $response = $client->execute($request);
        if ($debug)
        {
            echo '<pre>';
            print "Status Code: {$response->statusCode}\n";
            print "Status: {$response->result->status}\n";
            print "Order ID: {$response->result->id}\n";
            print "Intent: {$response->result->intent}\n";
            print "Links:\n";
            foreach($response->result->links as $link)
            {
                print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
            }
            // To toggle printing the whole response body comment/uncomment below line
            echo json_encode($response->result, JSON_PRETTY_PRINT), "\n";
        }


        return $response;
    }
}


