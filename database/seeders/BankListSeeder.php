<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Bank::create([
        //     'name_en' => 'National Commercial Bank',
        //     'name_ar' => 'National Commercial Bank'
        // ]);
        // This row has added in the 2023_04_01_100929_create_bank_lists_table page

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
}
