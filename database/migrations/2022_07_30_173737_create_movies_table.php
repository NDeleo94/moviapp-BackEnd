<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('image', 255)->default("");
            $table->string('language', 25);
            $table->string('genre', 25);
            $table->date('premiered');
            $table->string('summary', 255);
            $table->boolean('state')->default(true);
            $table->timestamps();

            //User's Relationship
            $table->foreignId('id_user')
                ->nullable()
                ->constrained('users')
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
        Schema::dropIfExists('movies');
    }
}
