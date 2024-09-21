<?php

use App\Http\Utilities\Utility;
use App\Models\FaqType;
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
        Schema::create('faq_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->string('name_ar',255)->nullable();
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
        FaqType::create(['name' => 'Faq Type1', 'name_ar' => 'Faq Type1', 'status' => 1, 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        FaqType::create(['name' => 'Faq Type2', 'name_ar' => 'Faq Type2', 'status' => 1, 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        FaqType::create(['name' => 'Faq Type3', 'name_ar' => 'Faq Type3', 'status' => 1, 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_types');
    }
};
