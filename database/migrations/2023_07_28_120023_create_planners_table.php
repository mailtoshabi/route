<?php

use App\Models\Delivery;
use App\Models\Planner;
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
        Schema::create('planners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_sale_id');
            $table->foreign('product_sale_id')->references('id')->on('product_sale')->cascadeOnDelete();
            $table->smallInteger('type')->comment('1:Delivery, 2:Pickup');
            $table->date('action_date')->nullable();
            $table->boolean('status')->default(1)->comment('1:Active 0:Completed');
            $table->timestamps();
        });

        Planner::create(['product_sale_id' => 1, 'type'=>1, 'action_date'=>'2024-01-15 06:36:36',  'status' => 1, 'created_at' => now(),]);
        Planner::create(['product_sale_id' => 2, 'type'=>2, 'action_date'=>'2024-01-20 06:36:36', 'status' => 1, 'created_at' => now(),]);
        Planner::create(['product_sale_id' => 3, 'type'=>1, 'action_date'=>'2024-02-10 06:36:36', 'status' => 1, 'created_at' => now(),]);
        Planner::create(['product_sale_id' => 3, 'type'=>2, 'action_date'=>'2024-03-8 06:36:36', 'status' => 1, 'created_at' => now(),]);
        Planner::create(['product_sale_id' => 3, 'type'=>1, 'action_date'=>'2024-03-12 06:36:36', 'status' => 1, 'created_at' => now(),]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planners');
    }
};
