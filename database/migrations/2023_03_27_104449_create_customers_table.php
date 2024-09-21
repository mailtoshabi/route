<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->double('latitude', 10, 6)->nullable();
            $table->double('longitude', 10, 6)->nullable();
            $table->string('building_no')->nullable();
            $table->string('street')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->text('image')->nullable();
            $table->string('lang',5)->nullable();
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->boolean('is_seller')->comment('1-seller 0-not seller')->default(0);
            $table->foreignId('verified_by')->nullable();
            $table->foreign('verified_by')->references('id')->on('users')->cascadeOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
        Customer::create(['first_name' => 'Shabeer', 'last_name' => 'CM', 'building_no' => 'KM-14B', 'street' => 'Kuruppath', 'district' => 'Malappuram', 'city' => 'Kondotty', 'postal_code' => '673638', 'country'=>'India', 'phone' => '9809373738', 'email' => 'shabeer@gmail.com','password' => Hash::make('123456'),'email_verified_at'=>'2022-01-02 17:04:58','lang' => 'EN', 'image' => '', 'created_at' => now(),]);
        Customer::create(['first_name' => 'Abdul Aziz', 'last_name' => 'Alharbi', 'building_no' => '204 Alamal Plaza', 'street' => 'Prince Sultan Street', 'district' => 'Al-Nuzhah','city' => 'Jeddah', 'postal_code' => '21577', 'country'=>'KSA', 'phone' => '+966543001003', 'email' => 'abdulaziz@route.sa','password' => Hash::make('123456'),'email_verified_at'=>'2022-01-02 17:04:58','lang' => 'EN', 'image' => '','created_at' => now()]);
        Customer::create(['first_name' => 'Shameer', 'last_name' => 'CM', 'building_no' => 'KM-14B', 'street' => 'Kuruppath', 'district' => 'Malappuram', 'city' => 'Kondotty', 'postal_code' => '673638', 'country'=>'India', 'phone' => '7902277077', 'email' => 'shameer@gmail.com','password' => Hash::make('123456'),'email_verified_at'=>'2022-01-02 17:04:58','lang' => 'EN', 'image' => '', 'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
