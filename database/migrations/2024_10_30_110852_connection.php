<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Connection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connection', function (Blueprint $table) {
            $table->id();
            $table->integer('nodeFrom');
            $table->integer('nodeTo');
            $table->text('connectionDesc');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->integer('byuserid');
        });

        //Putting Example Data
        DB::table('connection')->insert(
            ["id" => 1, "nodeFrom" => 3, "nodeTo" => 1, "connectionDesc" => 'sql',"created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1],
            ["id" => 2, "nodeFrom" => 3, "nodeTo" => 2, "connectionDesc" => 'smb',"created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1],
            ["id" => 5, "nodeFrom" => 3, "nodeTo" => 1, "connectionDesc" => 'sql',"created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connection');
    }
}
