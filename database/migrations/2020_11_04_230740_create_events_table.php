<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{

    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->date('date_event');
            $table->string('meeting_id')->unique();
            $table->string('password')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        // Schema::dropIfExists('events');
        Schema::table('events', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
