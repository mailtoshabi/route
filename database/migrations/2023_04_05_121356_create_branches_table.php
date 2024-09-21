<?php

use App\Http\Utilities\Utility;
use App\Models\Branch;
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
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->string('name_ar',255)->nullable();
            $table->string('phone',255)->nullable();
            // $table->string('email',255)->nullable();
            // $table->string('password');
            // $table->timestamp('email_verified_at')->nullable();
            $table->double('latitude', 10, 6)->nullable();
            $table->double('longitude', 10, 6)->nullable();
            $table->string('building_no')->nullable();
            $table->string('street')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
        Branch::create(['name' => 'Kuruppath', 'name_ar' => 'Warehouse 1', 'phone'=>'123456', 'building_no' => 'KM-14B', 'street' => 'Kuruppath', 'district' => 'Malappuram', 'city' => 'Jeddah', 'postal_code' => '22233','country'=>'India', 'image' => '', 'latitude'=>'11.142425', 'longitude'=>'75.970295', 'status' => 1,'image' => '', 'customer_id' => 3, 'created_by' => Utility::ADMIN_ID, 'created_at' => now(),]);
        Branch::create(['name' => 'Calicut', 'name_ar' => 'Warehouse 2', 'phone'=>'123456', 'building_no' => 'KM-14B', 'street' => 'Kuruppath', 'district' => 'Malappuram', 'city' => 'Dammam', 'postal_code' => '34223','country'=>'KSA', 'image' => '', 'latitude'=>'11.260013', 'longitude'=>'75.792509', 'status' => 1,'image' => '', 'customer_id' => 3, 'created_by' => Utility::ADMIN_ID, 'created_at' => now(),]);
        Branch::create(['name' => 'Pulikkal', 'name_ar' => 'Warehouse 3', 'phone'=>'123456', 'building_no' => 'KM-14B', 'street' => 'Kuruppath', 'district' => 'Malappuram', 'city' => 'Riyadh', 'postal_code' => '12271','country'=>'India', 'image' => '', 'latitude'=>'11.177071', 'longitude'=>'75.917457', 'status' => 1,'image' => '', 'customer_id' => 3, 'created_by' => Utility::ADMIN_ID, 'created_at' => now(),]);
        Branch::create(['name' => 'Ramanatukara', 'name_ar' => 'Warehouse 4', 'phone'=>'123456', 'building_no' => 'KM-14B', 'street' => 'Kuruppath', 'district' => 'Malappuram', 'city' => 'Riyadh', 'postal_code' => '12271','country'=>'India', 'image' => '', 'latitude'=>'11.188971', 'longitude'=>'75.868228', 'status' => 1,'image' => '', 'customer_id' => 3, 'created_by' => Utility::ADMIN_ID, 'created_at' => now(),]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
