<?php

use App\Models\Faq;
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
        Schema::create('faqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('faq_type_id')->nullable();
            $table->foreign('faq_type_id')->references('id')->on('faq_types')->onDelete('cascade');
            $table->boolean('status')->comment('1-Active 0-inactive')->default(1);
            $table->timestamps();
        });

        Faq::create(['faq_type_id'=>1, 'title' => 'Please make an Urgent call', 'description' => 'asdf asdfas asdfasd asfads asdfas', 'created_at' => now(),]);
        Faq::create(['faq_type_id'=>1, 'title' => 'Please make an Urgent call2', 'description' => '123 asdf asdfas asdfasd asfads asdfas', 'created_at' => now(),]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs');
    }
};
