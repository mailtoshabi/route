<?php

use App\Models\Vehicle;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers')->cascadeOnDelete();
            $table->string('manufacture')->nullable();
            $table->string('model')->nullable();
            $table->string('vnumber')->nullable();
            $table->string('chase_no')->nullable();
            $table->date('expiry')->nullable();
            $table->double('width')->nullable();
            $table->double('length')->nullable();
            $table->double('height')->nullable();
            $table->double('capacity')->nullable();
            $table->text('image')->nullable();
            $table->smallInteger('status')->default(1);
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
