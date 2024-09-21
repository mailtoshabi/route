<?php

use App\Http\Utilities\Utility;
use App\Models\RentalType;
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
        Schema::create('rental_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->string('name_ar',255)->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('slug')->nullable();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
        RentalType::create(['name' => 'Personal', 'name_ar' => 'Personal', 'image' => null, 'status' => 1,'slug' => 'rental_type-1','image' => '', 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        RentalType::create(['name' => 'Event', 'name_ar' => 'Event', 'image' => null, 'status' => 1,'slug' => 'rental_type-2','image' => '', 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        RentalType::create(['name' => 'Professional', 'name_ar' => 'Professional', 'image' => null, 'status' => 1,'slug' => 'rental_type-2','image' => '', 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental_types');
    }
};
