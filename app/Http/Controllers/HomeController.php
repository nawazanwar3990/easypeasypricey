<?php

namespace App\Http\Controllers;

use App\Enum\MethodEnum;
use App\Enum\ShopifyEndpointEnum;
use App\Models\Shop;
use App\Services\ShopService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function home(Request $request): View|Factory|RedirectResponse|Application
    {
        $pageTitle = trans('general.orders');
        $shop = ShopService::getShop();
        if ($shop) {
            $orders  = ShopService::call($shop->token,$shop->domain,ShopifyEndpointEnum::ORDERS);
            return view('dashboard', compact('shop','pageTitle',compact('orders')));
        } else {
            $domain = $request->query('shop');
            $hmac = $request->query('hmac');
            $timestamp = $request->query('timestamp');
            return redirect()->route('install', [
                'hmac' => $hmac,
                'shop' => $domain,
                'timestamp' => $timestamp
            ]);
        }
    }
    public function install(Request $request)
    {
        $domain = $request->query('shop', null);
        $hmac = $request->query('hmac', null);
        Shop::updateOrCreate([
            'domain' => $domain
        ], [
            'name' => $domain,
            'hmac' => $hmac
        ]);
        $install_url = "https://" . $domain . "/admin/oauth/authorize?client_id=" . env("SHOPIFY_API_KEY") . "&scope=" . env("SHOPIFY_API_SCOPES") . "&redirect_uri=" .urlencode(env('SHOPIFY_API_REDIRECT_URL'));
        header("Location: " . $install_url);
        die();
    }
    public function token(Request $request)
    {
        $params = $_GET;
        $hmac = $_GET['hmac'];
        $code = $_GET['code'];
        $params = array_diff_key((array)$params, array('hmac' => ''));
        ksort($params);
        $computed_hmac = hash_hmac('sha256', http_build_query($params), env("SHOPIFY_API_SECRET"));
        if (hash_equals($hmac, $computed_hmac)) {
            $domain = $request->query('shop', null);
            $result = $this->request($domain, $code);
            Shop::where('domain', $domain)->update([
                'token' => $result['access_token']
            ]);

            $shop = ShopService::getShopByDomainName($domain);
            ShopService::syncShopData($shop);
            $return_url = 'https://' . $domain . "/admin/apps/" . env("SHOPIFY_APP_NAME");
            header("Location: " . $return_url);
            die();
        } else {
            die('This request is NOT from Shopify!');
        }
    }

    public function request($shop, $code)
    {
        $query = array(
            "client_id" => env("SHOPIFY_API_KEY"),
            "client_secret" => env("SHOPIFY_API_SECRET"),
            "code" => $code
        );
        $access_token_url = "https://" . $shop . "/admin/oauth/access_token";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $access_token_url);
        curl_setopt($ch, CURLOPT_POST, count($query));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}
