<?php

namespace App\Http\Controllers;

use App\Enum\ShopifyEndpointEnum;
use App\Services\ShopService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {

    }

    public function edit(Request $request)
    {
        $shop = ShopService::getShop();
        if ($shop) {
            $endPoint = ShopifyEndpointEnum::ORDERS . "/" . $request->input('orderId');
            $orderRequest = ShopService::call($shop->token, $shop->domain, $endPoint);
            $orderResponse = json_decode($orderRequest['response'], JSON_PRETTY_PRINT);
            if (isset($orderResponse['order']) && count($orderResponse['order']) > 0) {
                $order = $orderResponse['order'];
                return view('components.order-items', compact('shop', 'order'))->render();
            }
        }
    }

    public function update(Request $request)
    {
        $records = $request->post();
        $graphQlOrder = "gid://shopify/Order/" . $request->query('orderId');
        $shop = ShopService::getShop();
        $graphQlUrl = 'https://' . $shop->domain . '/admin/api/2023-07/graphql.json';
        $beginOrderResponse = ShopService::beginOrderEdit($graphQlUrl, $shop->token, $graphQlOrder);

        if (isset($beginOrderResponse['data']['orderEditBegin']['calculatedOrder'])) {
            $calculatedOrder = $beginOrderResponse['data']['orderEditBegin']['calculatedOrder'];
            $calculatedOrderId = $calculatedOrder['id'];
            if (isset($calculatedOrder['lineItems']['edges']) && count($calculatedOrder['lineItems']['edges']) > 0) {
                foreach ($calculatedOrder['lineItems']['edges'] as $calculatedOrderItem) {
                    $calculatedItemId = $calculatedOrderItem['node']['id'];
                    $ItemId = substr(strrchr($calculatedItemId, "/"), 1);
                    if (array_key_exists($ItemId, $records)) {
                        $newQuantity = $records[$ItemId];
                        ShopService::setQuantity($graphQlUrl, $shop->token, $calculatedOrderId, $calculatedItemId, $newQuantity);
                    }
                }
                ShopService::commitOrderEdit($graphQlUrl, $shop->token, $calculatedOrderId);
            }
        }

        return response([
            'success' => true
        ]);
    }
}
