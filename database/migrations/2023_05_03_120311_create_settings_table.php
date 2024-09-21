<?php

use App\Models\Settings;
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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('term');
            $table->string('value')->nullable();
            $table->timestamps();
        });
        Settings::create(['term'=>'email', 'value'=>'admin@admin.com']);
        Settings::create(['term'=>'mobile', 'value'=>'9809373738']);
        Settings::create(['term'=>'whatsapp', 'value'=>'9809373738']);
        Settings::create(['term'=>'facebook', 'value'=>'www.facebook.com']);
        Settings::create(['term'=>'instagram ', 'value'=>'www.instagram.com']);
        Settings::create(['term'=>'youtube', 'value'=>'www.youtube.com']);
        Settings::create(['term'=>'address', 'value'=>'']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
