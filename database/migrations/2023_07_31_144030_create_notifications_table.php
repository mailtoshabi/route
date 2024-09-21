    <?php

use App\Http\Utilities\Utility;
use App\Models\Notification;
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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->smallInteger('type')->comment('0:all, 1:warehouse, 2:customer 3:driver',);
            $table->timestamps();
        });

        Notification::create(['description' => 'Please make an Urgent call', 'type' => Utility::MESSAGE_TYPE_ALL, 'created_at' => now(),]);
        Notification::create(['description' => 'It will seem like simplified English.', 'type' => Utility::MESSAGE_TYPE_DRIVER, 'created_at' => now(),]);
        Notification::create(['description' => 'If several languages coalesce the grammar', 'type' => Utility::MESSAGE_TYPE_BRANCH, 'created_at' => now(),]);
        Notification::create(['description' => 'If several languages coalesce the grammar', 'type' => Utility::MESSAGE_TYPE_DRIVER, 'created_at' => now(),]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
