<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('city')->nullable();
            $table->text('avatar')->nullable();
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->tinyInteger('utype')->default('1')->comment('1-Admin 2-Seller');
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
        User::create(['first_name' => 'Admin', 'last_name' => 'Route', 'city'=> 'Kondotty', 'email' => 'admin@route.sa','password' => Hash::make('123456'),'email_verified_at'=>'2022-01-02 17:04:58','avatar' => '','created_at' => now(),]);
        User::create(['first_name' => 'Aboobacker', 'last_name' => 'Siddique', 'city'=> 'Kondotty', 'email' => 'aboobacker@route.sa','password' => Hash::make('123456'),'email_verified_at'=>'2022-01-02 17:04:58','avatar' => '','created_at' => now(),]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
