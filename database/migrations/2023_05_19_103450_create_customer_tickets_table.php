<?php

use App\Models\CustomerTicket;
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
        Schema::create('customer_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('type')->default(1)->comment('1:Technical, 2:Sales, 3: Complaints');
            $table->smallInteger('escalation_level')->default(1)->comment('1:Agent, 2:Management, 3: Executive');
            $table->string('ticket_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->foreignId('sale_id')->nullable();
            $table->foreign('sale_id')->references('id')->on('sales')->cascadeOnDelete();
            $table->tinyInteger('status')->comment('1-Customer Posted 2-Admin Replied')->default(1);
            $table->boolean('open')->comment('1-Open 0-Close')->default(1);
            $table->foreignId('handler')->nullable();
            $table->foreign('handler')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });

        CustomerTicket::create(['type'=>1,'escalation_level'=>1,'ticket_id'=>'CT1-2023','title' => 'Please make an Urgent call', 'description' => 'asdf asdfas asdfasd asfads asdfas', 'customer_id'=> 1, 'sale_id'=>1, 'handler'=>2,'created_at' => now(),]);
        CustomerTicket::create(['type'=>1,'escalation_level'=>2,'ticket_id'=>'CT2-2023','title' => 'Please make an Urgent call2', 'description' => '123 asdf asdfas asdfasd asfads asdfas', 'customer_id'=> 1, 'sale_id'=>4, 'handler'=>2,'created_at' => now(),]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_tickets');
    }
};
