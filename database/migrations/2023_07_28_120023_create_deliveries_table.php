<?php

use App\Models\Delivery;
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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('drivers')->cascadeOnDelete();
            $table->morphs('deliverable');
            $table->double('delivery_charge')->default(0);
            $table->string('glocation_pickup')->nullable();
            $table->string('glocation_delivery')->nullable();
            $table->date('delivery_est_at')->nullable();
            $table->date('accepted_at')->nullable();
            $table->string('reason')->nullable();
            $table->date('rejected_at')->nullable();
            $table->smallInteger('type')->default(1)->comment('1:Delivery, 2:Pick Up');
            $table->smallInteger('status')->comment('0:New, 1:accept, 2:reject, 7:picked, 5:out for delivery, 5:out for pick up, 7:picked up, 6:delivered, 11:return to warehouse');
            $table->boolean('final_status')->default(0)->comment('0:open, 1:closed');

            $table->timestamps();
        });

        Delivery::create(['driver_id' => 1, 'deliverable_id'=>5, 'deliverable_type'=>'App\Models\ProductSale', 'delivery_charge' => 10, 'glocation_pickup' => 'Location', 'glocation_delivery'=>'Location', 'delivery_est_at'=>'2023-10-13 06:36:36', 'status' => 1, 'final_status'=>0, 'type'=>1, 'created_at' => now(),]);
        Delivery::create(['driver_id' => 1, 'deliverable_id'=>6, 'deliverable_type'=>'App\Models\ProductSale', 'delivery_charge' => 10, 'glocation_pickup' => 'Location', 'glocation_delivery'=>'Location', 'delivery_est_at'=>'2023-10-14 06:36:36', 'status' => 11, 'final_status'=>1, 'type'=>2, 'created_at' => now(),]);
        Delivery::create(['driver_id' => 1, 'deliverable_id'=>1, 'deliverable_type'=>'App\Models\ReturnSale', 'delivery_charge' => 10, 'glocation_pickup' => 'Location', 'glocation_delivery'=>'Location', 'delivery_est_at'=>'2023-10-14 06:36:36', 'status' => 1, 'final_status'=>0, 'type'=>1, 'created_at' => now(),]);
        Delivery::create(['driver_id' => 1, 'deliverable_id'=>7, 'deliverable_type'=>'App\Models\ProductSale', 'delivery_charge' => 10, 'glocation_pickup' => 'Location', 'glocation_delivery'=>'Location', 'delivery_est_at'=>'2023-10-14 06:36:36', 'status' => 6, 'final_status'=>0, 'type'=>1, 'created_at' => now(),]);
        Delivery::create(['driver_id' => 1, 'deliverable_id'=>7, 'deliverable_type'=>'App\Models\ProductSale', 'delivery_charge' => 10, 'glocation_pickup' => 'Location', 'glocation_delivery'=>'Location', 'delivery_est_at'=>'2023-10-14 06:36:36', 'status' => 6, 'final_status'=>0, 'type'=>1, 'created_at' => now(),]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
};
