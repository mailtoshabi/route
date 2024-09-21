<?php

use App\Http\Utilities\Utility;
use App\Models\Message;
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
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->smallInteger('type')->comment('0:all, 1:warehouse, 2:customer 3:driver',);
            $table->boolean('status')->comment('1-Active 0-Inactive')->default(1);
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();

        });
        Message::create(['title'=>'Lorem ipsum dolor sit amet','description' => 'Lorem ipsum dolor sit amet. Ut ipsa perferendis eos rerum necessitatibus id suscipit eius. Et accusamus iusto non blanditiis ipsa non fugiat quas qui omnis fugiat qui totam veniam. Et voluptatem dolorum et voluptas vitae in tenetur blanditiis qui quas aliquid ea temporibus dolores non atque nesciunt. Et enim illum sit explicabo veritatis nam inventore doloremque cum voluptas tempore.', 'type' => Utility::MESSAGE_TYPE_ALL, 'user_id' => Utility::ADMIN_ID, 'created_at' => now(),]);
        Message::create(['title'=>'In similique autem non quibusdam officiis','description' => 'In similique autem non quibusdam officiis eos inventore nostrum ea omnis saepe eos beatae unde vel eaque ipsam. Non tempore tempore aut nihil rerum non distinctio sunt sed dolor voluptates ex galisum error.', 'type' => Utility::MESSAGE_TYPE_DRIVER, 'user_id' => Utility::ADMIN_ID, 'created_at' => now(),]);
        Message::create(['title'=>'Why do you use?','description' => 'The Lorem ipum filling text is used by graphic designers, programmers and printers with the aim of occupying the spaces of a website, an advertising product or an editorial production whose final text is not yet ready.', 'type' => Utility::MESSAGE_TYPE_BRANCH, 'user_id' => Utility::ADMIN_ID, 'created_at' => now(),]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
