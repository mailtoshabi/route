<?php

use App\Http\Utilities\Utility;
use App\Models\Driver;
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
        Schema::create('drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('name');
            $table->string('building_no')->nullable();
            $table->string('street')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->text('image')->nullable();
            $table->string('iqama')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->string('branch_name')->nullable();
            $table->string('iban_number')->nullable();
            $table->string('account_number')->nullable();
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->morphs('driverable');
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
        Driver::create(['name' => 'Mohammed Swalih', 'image' => '', 'city' => 'Kondotty', 'phone'=>'1234567890', 'email' => 'driver@route.sa','password' => Hash::make('123456'), 'status' => 1, 'building_no' => 'KM-14B', 'street' => 'Kuruppath', 'district' => 'Malappuram', 'city' => 'Kondotty', 'postal_code' => '22233', 'country'=>'India','image' => '', 'driverable_id'=>1, 'driverable_type'=>'App\Models\Customer', 'created_by' => Utility::ADMIN_ID, 'created_at' => now(),]);
        Driver::create(['name' => 'Mohammed Shafi', 'image' => '', 'city' => 'Jeddah', 'phone'=>'1234567890', 'email' => 'driver2@route.sa','password' => Hash::make('123456'), 'status' => 1, 'building_no' => 'KM-14B', 'street' => 'Kuruppath', 'district' => 'Malappuram', 'city' => 'Riyadh', 'postal_code' => '22233', 'country'=>'KSA','image' => '', 'driverable_id'=>3, 'driverable_type'=>'App\Models\Shipper', 'created_by' => Utility::ADMIN_ID, 'created_at' => now(),]);
        Driver::create(['name' => 'Sulaiman M', 'image' => '', 'city' => 'Kondotty', 'phone'=>'1234567890', 'email' => 'driver3@route.sa','password' => Hash::make('123456'), 'status' => 1, 'building_no' => 'KM-14B', 'street' => 'Kuruppath', 'district' => 'Malappuram', 'city' => 'Kondotty', 'postal_code' => '22233', 'country'=>'India','image' => '', 'driverable_id'=>2, 'driverable_type'=>'App\Models\Customer', 'created_by' => Utility::ADMIN_ID, 'created_at' => now(),]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
};
