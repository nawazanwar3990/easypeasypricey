<?php

namespace App\Services;

use App\Enum\MethodEnum;
use App\Enum\ShopifyEndPointEnum;
use App\Models\Shop;

class ShopService
{
    public static function call(
        $token,
        $shop,
        $api_endpoint,
        $query = array(),
        $method = 'GET',
        $request_headers = array()
    ): array|string
    {
        $url = "https://" . $shop . "/admin/api/" . env('SHOPIFY_API_VERSION') . "/" . $api_endpoint . ".json";
        if (!is_null($query) && in_array($method, array('GET', 'DELETE'))) $url = $url . "?" . http_build_query($query);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'My New ShopifyService App v.1');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        $request_headers[] = "";
        if (in_array($method, array('POST', 'PUT'))) {
            $query = json_encode($query);
            $request_headers = in_array($method, array('POST', 'PUT')) ? array("Content-Type: application/json; charset=utf-8", 'Expect:') : array();
        } else {
            $query = array();
        }
        if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
        if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
            if (is_array($query)) $query = http_build_query($query);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        }
        $response = curl_exec($curl);
        $error_number = curl_errno($curl);
        $error_message = curl_error($curl);
        curl_close($curl);
        if ($error_number) {
            return $error_message;
        } else {
            $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);
            $headers = array();
            $header_data = explode("\n", $response[0]);
            $headers['status'] = $header_data[0];
            array_shift($header_data);
            foreach ($header_data as $part) {
                $h = explode(":", $part, 2);
                $headers[trim($h[0])] = trim($h[1]);
            }
            return array('headers' => $headers, 'response' => $response[1]);
        }
    }

    public static function getShopifyNextPageArray($header): array
    {
        $response = array();
        if (isset($header['link'])) {
            $links = explode(',', $header['link']);
            foreach ($links as $link) {
                if (strpos($link, 'rel="next"')) {
                    preg_match('~<(.*?)>~', $link, $next);
                    $url_components = parse_url($next[1]);
                    parse_str($url_components['query'], $params);
                    $response['next_page'] = $params['page_info'];
                    $response['last_page'] = false;
                } else {
                    $response['last_page'] = true;
                }
            }
        } else {
            $response['last_page'] = true;
        }
        return $response;
    }

    public static function getAppRequests($request): array
    {
        $requestArray = array();
        $requestArray['hmac'] = $request->get('hmac', null);
        $requestArray['locale'] = $request->get('locale', null);
        $requestArray['new_design_language'] = $request->get('new_design_language', null);
        $requestArray['session'] = $request->get('session', null);
        $requestArray['shop'] = $request->get('shop', null);
        $requestArray['timestamp'] = $request->get('timestamp', null);
        $domain = $request->get('shop', null);
        $store = Shop::whereDomain($domain)->first();
        $requestArray['shop_id'] = $store->id;
        $requestArray['domain'] = $store->domain;
        $requestArray['token'] = $store->token;
        return $requestArray;
    }

    public static function getShopId()
    {
        return self::getShop()->id;
    }

    public static function getShop()
    {
        return Shop::where('domain', self::getShopDomain())->first();
    }

    public static function getShopDomain()
    {
        return request()->get('shop', null);
    }

    public static function getShopByDomainName($domain)
    {
        return Shop::where('domain', $domain)->first();
    }

    public static function syncShopData($shop)
    {
        $request = self::call(
            $shop->token,
            $shop->domain,
            ShopifyEndPointEnum::SHOP,
            null,
            MethodEnum::GET
        );
        $response = json_decode($request['response'], JSON_PRETTY_PRINT);
        if (isset($response['shop']) && count($response['shop']) > 0) {
            self::manageShop($response['shop']);
        }
    }

    public static function manageShop($shop)
    {
        Shop::updateOrCreate([
            'domain' => $shop['myshopify_domain']
        ], [
            'domain' => $shop['myshopify_domain'],
            'email' => $shop['email'],
            'store_id' => trim($shop['id']),
            'primary_location_id' => trim($shop['primary_location_id']),
            'primary_locale' => $shop['primary_locale'] ?? null,
            'country' => $shop['country'] ?? null,
            'province' => $shop['province'] ?? null,
            'city' => $shop['city'] ?? null,
            'address1' => $shop['address1'] ?? null,
            'address2' => $shop['address2'] ?? null,
            'zip' => $shop['zip'] ?? null,
            'latitude' => $shop['latitude'] ?? null,
            'longitude' => $shop['longitude'] ?? null,
            'currency' => $shop['currency'] ?? null,
            'enabled_presentment_currencies' => json_encode($shop['enabled_presentment_currencies']),
            'money_format' => $shop['money_format'] ?? null,
            'store_name' => $shop['name'] ?? null,
            'store_owner' => $shop['shop_owner'] ?? null,
            'plan_display_name' => $shop['plan_display_name'] ?? null,
            'plan_name' => $shop['plan_name'] ?? null,
            'force_ssl' => $shop['force_ssl'] ?? null,
            'store_created_at' => $shop['created_at'] ?? null,
            'store_updated_at' => $shop['updated_at'] ?? null,
        ]);
    }
}
