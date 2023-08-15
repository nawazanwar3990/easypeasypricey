<?php

namespace App\Http\Controllers;

use App\Models\Shopify\Customer;
use App\Models\Shopify\Store;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function createForWebHook(): JsonResponse
    {
        $customer = json_decode(file_get_contents('php://input'), true);
        $storeQuery = Store::whereDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($storeQuery->exists()) {
            $store = $storeQuery->first();
            Customer::manageCustomer($customer, $store);
        }
        return response()->json([
            'status' => 200
        ]);
    }

    public function updateForWebHook(): JsonResponse
    {
        $customer = json_decode(file_get_contents('php://input'), true);
        $storeQuery = Store::whereDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($storeQuery->exists()) {
            $store = $storeQuery->first();
            Customer::manageCustomer($customer, $store);
        }
        return response()->json([
            'status' => 200
        ]);
    }
    public function deleteForWebHook(): JsonResponse
    {
        $customer_id = json_decode(file_get_contents('php://input'), true)['id'];
        $storeQuery = Store::whereDomain($_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']);
        if ($storeQuery->exists()) {
            $store = $storeQuery->first();
            $customer_id = strval(trim($customer_id));
            $store_id = strval(trim($store->store_id));
            Customer::where('customer_id', $customer_id)->where('store_id', $store_id)->delete();
        }
        return response()->json([
            'status' => 200
        ]);
    }
}
