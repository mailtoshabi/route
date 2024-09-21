<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerReview;
use App\Models\CustomerTicket;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductSale;
use App\Models\Sale;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Schema::disableForeignKeyConstraints();
        // $this->call(UserSeeder::class);
        // $this->call(BankListSeeder::class);
        // Schema::enableForeignKeyConstraints();

        Category::factory(100)->create();
        SubCategory::factory(300)->create();
        Customer::factory(200)
        ->has(CustomerAddress::factory()->count(2),'customer_addresses')
        ->has(Branch::factory()->count(3),'branches')
        // ->has(CustomerReview::factory()->count(3),'reviews')
        ->has(CustomerTicket::factory()->count(3),'tickets')
        ->create();
        Product::factory(1000)
        ->has(ProductReview::factory()->count(3),'product_reviews')->create();


        CustomerReview::factory(600)->create();
        // ProductReview::factory(600)->create();
        // Sale::factory(500)->create();
        $sale = Sale::factory(700)
        ->has(ProductSale::factory()->count(1),'product_sales')
        ->create();

        // ProductSale::factory()->count(1)->for($sale)->create();
    }
}
