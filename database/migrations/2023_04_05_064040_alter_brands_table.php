<?php

use App\Http\Utilities\Utility;
use App\Models\Brand;
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
        Schema::table('brands', function (Blueprint $table) {
            $table->string('name_ar',255)->nullable()->after('name');
            $table->text('slug')->nullable()->after('status');
        });
        Brand::create(['name' => 'Brand1', 'name_ar' => 'Brand1', 'image' => null, 'status' => 1,'image' => '', 'user_id' => Utility::ADMIN_ID,'created_at' => now(),]);
        Brand::create(['name' => 'Brand2', 'name_ar' => 'Brand2', 'image' => null, 'status' => 1,'image' => '', 'user_id' => Utility::ADMIN_ID,'created_at' => now(),]);
        Brand::create(['name' => 'Brand3', 'name_ar' => 'Brand3', 'image' => null, 'status' => 1,'image' => '', 'user_id' => Utility::ADMIN_ID,'created_at' => now(),]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('name_ar');
            $table->dropColumn('slug');
        });
    }
};
