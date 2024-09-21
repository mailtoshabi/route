<?php

use App\Http\Utilities\Utility;
use App\Models\TaxType;
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
        Schema::create('tax_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->double('perc');
            $table->boolean('status')->default(1)->comment('1:Active 0:Inactive');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
        TaxType::create(['name' => '5%', 'perc' => 5, 'status' => 1, 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
        TaxType::create(['name' => '10%', 'perc' => 10, 'status' => 1, 'user_id' => Utility::ADMIN_ID,'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_types');
    }
};
