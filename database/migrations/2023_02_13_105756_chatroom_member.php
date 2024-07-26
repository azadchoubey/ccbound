    <?php

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
        Schema::create('chatroom_member', function (Blueprint $table) {
            $table->foreignId('chatroom_id');
            $table->foreignId('user_id');
            $table->boolean('chat_left')->default(false);
            $table->foreignId('messages_deleted_till')->default(0);
            $table->foreignId('chat_left_at')->default(0);
            // $table->boolean('is_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
