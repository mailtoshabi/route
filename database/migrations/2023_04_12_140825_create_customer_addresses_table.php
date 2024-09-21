<?php

use App\Models\CustomerAddress;
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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->string('building_no')->nullable();
            $table->string('street')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->double('latitude', 10, 6)->nullable();
            $table->double('longitude', 10, 6)->nullable();
            $table->boolean('default')->comment('1-default 0-Not defualt')->default(0);
            $table->timestamps();
        });
        CustomerAddress::create(['customer_id'=>1, 'building_no' => 'Marakkar House', 'street' => 'Kaloth', 'district' => 'Malappuam','city' => 'Kondotty','postal_code' => '673638', 'country'=>'India', 'default' =>1, 'created_at' => now(),]);
        CustomerAddress::create(['customer_id'=>1, 'building_no' => 'Perumthodi House', 'street' => 'Kuruppath', 'district' => 'Malappuam','city' => 'Kondotty','postal_code' => '673638', 'country'=>'India', 'default' =>0,'created_at' => now(),]);
        CustomerAddress::create(['customer_id'=>2, 'building_no' => 'Building 123', 'street' => 'Al-Nakheel', 'district' => 'Al-Olaya','city' => 'Riyadh','postal_code' => '12345-6789', 'country'=>'KSA', 'default' =>1,'created_at' => now(),]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_addresses');
    }
};
