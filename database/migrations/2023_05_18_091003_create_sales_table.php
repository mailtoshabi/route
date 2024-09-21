<?php

use App\Http\Utilities\Utility;
use App\Models\Sale;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->smallInteger('pay_method')->default(1);
            $table->double('sub_total')->default(0);
            $table->boolean('is_paid')->comment('1-paid,0-not paid')->default(0);
            $table->double('latitude', 10, 6)->nullable();
            $table->double('longitude', 10, 6)->nullable();
            $table->boolean('is_delivery')->comment('1-delivery,0-pickup')->default(1);
            $table->double('delivery_charge_total')->default(0);
            $table->foreignId('customer_address_id')->nullable();
            $table->foreign('customer_address_id')->references('id')->on('customer_addresses')->cascadeOnDelete();
            $table->smallInteger('status')->default(1);
            $table->timestamps();
        });

         Sale::create(['customer_id' => 1, 'sub_total' => 400,'pay_method'=>Utility::PAYMENT_ONLINE, 'is_delivery'=>1,'delivery_charge_total'=>50,'customer_address_id'=>1, 'created_at' => now(),]);
         Sale::create(['customer_id' => 2, 'sub_total' => 100,'pay_method'=>Utility::PAYMENT_COD, 'is_delivery'=>1,'delivery_charge_total'=>25,'customer_address_id'=>2, 'created_at' => now(),]);
         Sale::create(['customer_id' => 2, 'sub_total' => 200,'pay_method'=>Utility::PAYMENT_COD, 'is_delivery'=>0,'delivery_charge_total'=>0,'customer_address_id'=>3, 'created_at' => '2023-08-17 06:36:36',]);
         Sale::create(['customer_id' => 1, 'sub_total' => 200,'pay_method'=>Utility::PAYMENT_COD, 'is_delivery'=>0,'delivery_charge_total'=>0,'customer_address_id'=>1, 'created_at' => '2023-08-17 06:36:36',]);
         Sale::create(['customer_id' => 1, 'sub_total' => 100,'pay_method'=>Utility::PAYMENT_ONLINE, 'is_delivery'=>1,'delivery_charge_total'=>20,'customer_address_id'=>1, 'created_at' => '2023-08-17 06:36:36',]);
         Sale::create(['customer_id' => 1, 'sub_total' => 100,'pay_method'=>Utility::PAYMENT_ONLINE, 'is_delivery'=>1,'delivery_charge_total'=>20,'customer_address_id'=>1, 'created_at' => '2023-08-17 06:36:36',]);
         Sale::create(['customer_id' => 2, 'sub_total' => 100,'pay_method'=>Utility::PAYMENT_ONLINE, 'is_delivery'=>1,'delivery_charge_total'=>20,'customer_address_id'=>1, 'created_at' => '2023-08-17 06:36:36',]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
