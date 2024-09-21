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
        Schema::create('product_rent_term', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_id');
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreignId('rent_term_id');
            $table->foreign('rent_term_id')->references('id')->on('rent_terms')->cascadeOnDelete();
            $table->double('price')->nullable();
            $table->timestamps();
        });
        DB::table('product_rent_term')->insert([
            ['product_id' => 1, 'rent_term_id'=>1, 'price'=>100, 'created_at'=>now()],
            ['product_id' => 1, 'rent_term_id'=>2, 'price'=>50, 'created_at'=>now()],
            ['product_id' => 1, 'rent_term_id'=>3, 'price'=>20, 'created_at'=>now()],
            ['product_id' => 2, 'rent_term_id'=>1, 'price'=>100, 'created_at'=>now()],
            ['product_id' => 2, 'rent_term_id'=>2, 'price'=>50, 'created_at'=>now()],
            ['product_id' => 2, 'rent_term_id'=>3, 'price'=>20, 'created_at'=>now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_rent_term');
    }
};
