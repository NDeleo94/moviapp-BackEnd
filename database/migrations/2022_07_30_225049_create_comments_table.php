<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment', 255);
            $table->boolean('state')->default(true);
            $table->timestamps();

            //User's Relationship
            $table->foreignId('id_user')
                  ->nullable()
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            //User's Relationship
            $table->foreignId('id_movie')
                  ->nullable()
                  ->constrained('movies')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
