<?php

use App\Enum\DataSyncTypeEnum;
use App\Enum\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists(TableEnum::SHOPS);
        Schema::create(TableEnum::SHOPS, function (Blueprint $table) {
            $table->id();
            $table->text('store_id')->nullable();
            $table->string('store_name')->nullable();
            $table->string('store_owner')->nullable();
            $table->text('domain')->nullable();
            $table->text('primary_location_id')->nullable();
            $table->text('primary_locale')->nullable();
            $table->text('email')->nullable();
            $table->text('country')->nullable();
            $table->text('province')->nullable();
            $table->text('city')->nullable();
            $table->longText('address1')->nullable();
            $table->longText('address2')->nullable();
            $table->text('zip')->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->text('currency')->nullable();
            $table->json('enabled_presentment_currencies')->nullable();
            $table->text('money_format')->nullable();
            $table->string('plan_display_name')->nullable();
            $table->string('plan_name')->nullable();
            $table->string('force_ssl')->nullable();
            $table->longText('hmac')->nullable();
            $table->longText('token')->nullable();
            $table->string('store_created_at')->nullable();
            $table->string('store_updated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TableEnum::SHOPS);
    }
}
