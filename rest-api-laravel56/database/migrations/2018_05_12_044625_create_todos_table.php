<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('todos', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->primary('uuid');
            $table->enum('type', ['shopping', 'work'])->nullable(false);
            $table->string('content')->nullable(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('done')->default(false);;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
}
