<?php

use App\Http\Utilities\Utility;
use App\Models\RentTerm;
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
        Schema::create('rent_terms', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('name_ar',255)->nullable();
            $table->double('days');
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->foreignId('created_by');
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
        RentTerm::create(['name' => 'Daily', 'name_ar' => 'Daily', 'days' => 1, 'created_by' => Utility::ADMIN_ID,'created_at' => now()]);
        RentTerm::create(['name' => 'Weekly', 'name_ar' => 'Weekly', 'days' => 7, 'created_by' => Utility::ADMIN_ID,'created_at' => now()]);
        RentTerm::create(['name' => 'Monthly', 'name_ar' => 'Monthly', 'days' => 30, 'created_by' => Utility::ADMIN_ID,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_terms');
    }
};
