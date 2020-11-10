<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Cambiar nombre a event_user
class CreateEventsXUsersTable extends Migration
{

    public function up()
    {
        Schema::create('events_x_users', function (Blueprint $table) {
            $table->foreignId('event_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events_x_users');
    }
}
