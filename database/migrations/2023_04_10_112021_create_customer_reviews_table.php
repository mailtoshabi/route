<?php

use App\Models\CustomerReview;
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
        Schema::create('customer_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('description');
            $table->integer('rating');
            $table->foreignId('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->foreignId('seller_id');
            $table->foreign('seller_id')->references('id')->on('customers')->cascadeOnDelete();
            // $table->morphs('creviewable');
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->timestamps();
        });
        CustomerReview::create(['description' => 'The Service was great. He was very helpful and answered all our questions and service was always on time. Will be coming back to his sevices! Thank you so much.', 'rating' => 5, 'customer_id' => 2, 'seller_id' => 3, 'created_at' => now(),]);
        CustomerReview::create(['description' => 'I got a pair of boots from store X and I’m very satisfied. They are high-quality and worth the money. The store also offered free shipping at that price so that’s a plus!', 'rating' => 4, 'customer_id' => 2,'seller_id'=>3, 'created_at' => now(),]);
        CustomerReview::create(['description' => 'The Service was great. He was very helpful and answered all our questions and service was always on time. Will be coming back to his sevices! Thank you so much.', 'rating' => 5, 'customer_id' => 1, 'seller_id' => 3, 'created_at' => now(),]);
        CustomerReview::create(['description' => 'I ordered a mobile from him last week, and I was amazed at how quickly it arrived. The packaging was secure, ensuring the item was undamaged. The customer service was exceptional, as they kept me updated throughout the entire process.', 'rating' => 5, 'customer_id' => 2,'seller_id'=>3, 'created_at' => now(),]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_reviews');
    }
};
