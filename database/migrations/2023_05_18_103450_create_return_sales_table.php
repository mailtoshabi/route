<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('return_sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable(); //TODO: should suffix and prefix in settings.
            $table->foreignId('product_sale_id');
            $table->foreign('product_sale_id')->references('id')->on('product_sale')->cascadeOnDelete();
            $table->string('reason')->nullable();
            $table->boolean('is_replacement')->default(0)->comment('0:cashback, 1:replacement');
            $table->date('date_accepted')->nullable();
            $table->date('date_out_pickup')->nullable();
            $table->date('date_picked')->nullable();
            $table->date('date_closed')->nullable(); // return to warehouse
            $table->smallInteger('status')->default(0)->comment('0:new, 1:accept, 2:out for pick up, 3:picked up, 4:return to warehouse');
            $table->timestamps();
        });
        DB::table('return_sales')->insert([
            ['invoice_no'=>'RTN001/2023', 'product_sale_id' => 3, 'reason' => 'Bad quality','created_at' => '2023-08-19 06:36:36'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_sales');
    }
};
