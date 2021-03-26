<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('demander')->nullable();// phone 
            $table->string('priority')->nullable(); // Urgent / Medium / Normal
            $table->string('status')->nullable();// placer / accepter / complete
            $table->text('description')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('ville_id')->nullable(); // to-do For Future Statitics :)
            $table->unsignedBigInteger('donneur_id')->nullable();
            $table->timestamps();

            //$table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
            //$table->foreign('donneur_id')->references('id')->on('donneurs')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dons');
    }
}
