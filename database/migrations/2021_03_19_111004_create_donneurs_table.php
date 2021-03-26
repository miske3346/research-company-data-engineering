<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonneursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donneurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('prenom')->nullable();
            $table->string('nom')->nullable();
            $table->integer('nni')->nullable();
            $table->date('date_naissance')->nullable();
            $table->unsignedBigInteger('place_naissance')->nullable();
            $table->string('gender')->nullable();
            $table->string('contact_time')->nullable();
            $table->string('contact_methode')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('organisation_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('ville_id')->nullable();
            $table->timestamps();

           // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
           // $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade')->onUpdate('cascade');
           // $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
           // $table->foreign('ville_id')->references('id')->on('villes')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donneurs');
    }
}
