<?php

use App\Http\Utilities\Utility;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sale', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('sale_id');
            $table->foreign('sale_id')->references('id')->on('sales')->cascadeOnDelete();
            $table->foreignId('product_id');
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->string('invoice_no')->nullable(); //TODO: should suffix and prefix in settings.
            $table->double('price');
            $table->double('vat')->nullable();
            $table->double('delivery_charge')->default(0);
            $table->foreignId('rent_term_id')->nullable();
            $table->foreign('rent_term_id')->references('id')->on('rent_terms')->cascadeOnDelete();
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->boolean('is_paid')->comment('1-paid,0-not paid')->default(0);
            $table->boolean('is_confirmed')->comment('1-confirmed,0-not confirmed')->default(0);
            $table->boolean('is_refundable')->default(1);
            $table->date('date_accepted')->nullable();
            $table->date('date_ready')->nullable();
            $table->date('date_dispatched')->nullable();
            $table->date('date_out_delivery')->nullable();
            $table->date('date_delivered')->nullable();
            $table->date('date_closed')->nullable();
            $table->date('date_onhold')->nullable();
            $table->date('date_cancelled')->nullable();
            $table->smallInteger('status')->default(0)->comment('0:pending confirm, 1:confirmed, 2:Ready to Ship, 3:Dispatched, 4:Out for delivery, 5:Delivered, 6:Closed, 7:On Hold, 8:Cancelled');
            $table->boolean('status_delivery')->default(0)->comment('0:open, 1:closed');
            $table->boolean('status_pickup')->default(0)->comment('0:open, 1:closed');
            $table->timestamps();
        });
        DB::table('product_sale')->insert([
            ['invoice_no' => '5555', 'sale_id' => 1, 'product_id' => 1, 'price'=>50, 'vat'=>5, 'rent_term_id'=>2, 'is_paid'=>1, 'starts_at'=>Carbon::now()->addDays(1),'ends_at'=>Carbon::now()->addDays(8),'date_delivered'=>null, 'status'=>0, 'created_at' => Carbon::now(),'date_ready'=> null,'delivery_charge'=>0, 'status_delivery'=>0, 'status_pickup'=>0],
            ['invoice_no' => '5556', 'sale_id' => 2, 'product_id' => 2, 'price'=>20, 'vat'=>2,'rent_term_id'=>3, 'is_paid'=>1, 'starts_at'=>Carbon::now()->addDays(1),'ends_at'=>Carbon::now()->addDays(8),'date_delivered'=>null, 'status'=>0, 'created_at' => Carbon::now(),'date_ready'=> null,'delivery_charge'=>0, 'status_delivery'=>0, 'status_pickup'=>0],
            ['invoice_no' => '5557', 'sale_id' => 3, 'product_id' => 2, 'price'=>20, 'vat'=>2,'rent_term_id'=>3, 'is_paid'=>1, 'starts_at'=>Carbon::now()->subDays(14),'ends_at'=>Carbon::now()->addDays(16),'date_delivered'=>Carbon::now()->subDays(14), 'status'=>Utility::STATUS_DELIVERED, 'created_at' => Carbon::now()->subDays(15),'date_ready'=> null,'delivery_charge'=>0, 'status_delivery'=>1, 'status_pickup'=>0],
            ['invoice_no' => '5558', 'sale_id' => 4, 'product_id' => 2, 'price'=>100, 'vat'=>10,'rent_term_id'=>1, 'is_paid'=>0, 'starts_at'=>Carbon::now()->subDays(3),'ends_at'=>Carbon::now()->addDays(2),'date_delivered'=>Carbon::now()->subDays(3), 'status'=>Utility::STATUS_DELIVERED, 'created_at' => Carbon::now()->subDays(4),'date_ready'=> null,'delivery_charge'=>0, 'status_delivery'=>1, 'status_pickup'=>0],
            ['invoice_no' => '5559', 'sale_id' => 5, 'product_id' => 1, 'price'=>100, 'vat'=>10,'rent_term_id'=>1, 'is_paid'=>1, 'starts_at'=>Carbon::now()->subDays(1),'ends_at'=>Carbon::now()->addDays(2),'date_delivered'=>Carbon::now()->subDays(1), 'status'=>Utility::STATUS_DELIVERED, 'created_at' => Carbon::now()->subDays(2),'date_ready'=> '2023-08-18 06:36:36','delivery_charge'=>10, 'status_delivery'=>1, 'status_pickup'=>0],
            ['invoice_no' => '5560', 'sale_id' => 6, 'product_id' => 1, 'price'=>100, 'vat'=>10,'rent_term_id'=>1, 'is_paid'=>1, 'starts_at'=>Carbon::now()->subDays(89),'ends_at'=>Carbon::now()->subDays(84),'date_delivered'=> Carbon::now()->subDays(89), 'status'=>Utility::STATUS_CLOSED, 'created_at' => Carbon::now()->subDays(90),'date_ready'=> null,'delivery_charge'=>10, 'status_delivery'=>1, 'status_pickup'=>1],
            ['invoice_no' => '5561', 'sale_id' => 7, 'product_id' => 1, 'price'=>100, 'vat'=>10,'rent_term_id'=>1, 'is_paid'=>1, 'starts_at'=>Carbon::now()->subDays(119),'ends_at'=>Carbon::now()->subDays(116),'date_delivered'=> Carbon::now()->subDays(119), 'status'=>Utility::STATUS_CLOSED, 'created_at' => Carbon::now()->subDays(120),'date_ready'=> null,'delivery_charge'=>10, 'status_delivery'=>1, 'status_pickup'=>1],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sale');
    }
};
