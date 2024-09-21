<?php

use App\Models\DriverTicket;
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
        Schema::create('driver_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ticket_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers')->cascadeOnDelete();
            $table->tinyInteger('status')->comment('1-Customer Posted 2-Admin Replied')->default(1);
            $table->boolean('approve')->comment('1-Open 0-Closed')->default(1);
            $table->timestamps();
        });
        DriverTicket::create(['ticket_id'=>'DT1-2023','title' => 'Please make an Urgent call', 'description' => 'asdf asdfas asdfasd asfads asdfas', 'driver_id'=> 1,'created_at' => now(),]);
        DriverTicket::create(['ticket_id'=>'DT2-2023','title' => 'Please make an Urgent call2', 'description' => '123 asdf asdfas asdfasd asfads asdfas', 'driver_id'=> 1,'created_at' => now(),]);
        DriverTicket::create(['ticket_id'=>'DT1-2023','title' => 'Please make an Urgent call', 'description' => 'asdf asdfas asdfasd asfads asdfas', 'driver_id'=> 2,'created_at' => now(),]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_tickets');
    }
};
