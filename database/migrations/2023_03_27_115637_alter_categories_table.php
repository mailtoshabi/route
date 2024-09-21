<?php

use App\Http\Utilities\Utility;
use App\Models\Category;
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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name_ar',255)->nullable()->after('name');
            $table->text('slug')->nullable()->after('meta_description');
        });
        Category::create(['name' => 'Category1', 'name_ar' => 'Category1', 'image' => null, 'rental_type_id' => 1, 'status' => 1,'slug' => 'category-1','image' => '', 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        Category::create(['name' => 'Category2', 'name_ar' => 'Category2', 'image' => null, 'rental_type_id' => 2, 'status' => 1,'slug' => 'category-2','image' => '', 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        Category::create(['name' => 'Category3', 'name_ar' => 'Category3', 'image' => null, 'rental_type_id' => 2, 'status' => 0,'slug' => 'category-2','image' => '', 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('name_ar');
            $table->dropColumn('slug');
        });
    }
};
