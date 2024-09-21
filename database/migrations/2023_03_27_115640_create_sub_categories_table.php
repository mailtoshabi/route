<?php

use App\Http\Utilities\Utility;
use App\Models\SubCategory;
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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->string('name_ar',255)->nullable();
            $table->foreignId('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
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

        SubCategory::create(['name' => 'Sub Category1', 'name_ar' => 'Sub Category1', 'image' => null, 'category_id' => 1, 'status' => 1,'slug' => 'category-1','image' => '', 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        SubCategory::create(['name' => 'Sub Category2', 'name_ar' => 'Sub Category2', 'image' => null, 'category_id' => 2, 'status' => 1,'slug' => 'category-2','image' => '', 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        SubCategory::create(['name' => 'Sub Category3', 'name_ar' => 'Sub Category3', 'image' => null, 'category_id' => 2, 'status' => 1,'slug' => 'category-2','image' => '', 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
};
