<?php

namespace App\Models;

use App\Enum\TableEnum;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = TableEnum::SHOPS;
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'email',
        'store_id',
        'primary_location_id',
        'domain',
        'primary_locale',
        'country',
        'province',
        'city',
        'address1',
        'address2',
        'zip',
        'latitude',
        'longitude',
        'currency',
        'enabled_presentment_currencies',
        'money_format',
        'store_name',
        'store_owner',
        'plan_display_name',
        'plan_name',
        'force_ssl',
        'hmac',
        'token',
        'store_created_at',
        'store_updated_at'
    ];
}
