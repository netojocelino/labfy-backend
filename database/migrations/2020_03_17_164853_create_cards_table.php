<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('card_id');
            $table->string('title');
            $table->enum('list_state', ['TODO','DOING','DONE', 'FRIDGE']);
            $table->string('content');
            $table->timestamps('created_at');
            $table->enum('label', ['#7159c1', '#54e1f7', '#3c8dbc']);
            $table->string('created_by');
            $table->timestamps('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
