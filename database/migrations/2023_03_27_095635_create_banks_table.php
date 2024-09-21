<?php

use App\Models\Bank;
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
        Schema::create('banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Bank::create([
            'name_en' => 'National Commercial Bank',
            'name_ar' => 'National Commercial Bank'
        ]);

        Bank::create([
            'name_en' => 'Al Rajhi Bank',
            'name_ar' => 'Al Rajhi Bank'
        ]);

        Bank::create([
            'name_en' => 'Samba Financial Group',
            'name_ar' => 'Samba Financial Group'
        ]);

        Bank::create([
            'name_en' => 'Riyad Bank',
            'name_ar' => 'Riyad Bank'
        ]);

        Bank::create([
            'name_en' => 'Banque Saudi Fransi',
            'name_ar' => 'Banque Saudi Fransi'
        ]);

        Bank::create([
            'name_en' => 'Saudi British Bank (SABB)',
            'name_ar' => 'Saudi British Bank (SABB)'
        ]);

        Bank::create([
            'name_en' => 'Arab National Bank',
            'name_ar' => 'Arab National Bank'
        ]);

        Bank::create([
            'name_en' => 'Alinma Bank',
            'name_ar' => 'Alinma Bank'
        ]);

        Bank::create([
            'name_en' => 'Alawwal Bank',
            'name_ar' => 'Alawwal Bank'
        ]);

        Bank::create([
            'name_en' => 'Saudi Investment Bank',
            'name_ar' => 'Saudi Investment Bank'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banks');
    }
};
