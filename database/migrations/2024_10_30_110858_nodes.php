<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Nodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('category_id');
            $table->text('active');
            $table->text('description');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->integer('byuserid');
        });
        
        //Putting Example Data
        DB::table('nodes')->insert(
            ["id" => 1, "name" => 'Database', "category_id" => 1, "active" => 'on',"description"=> 'MSSQL database,\n587 port', "created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1],
            ["id" => 2, "name" => 'FileServer', "category_id" => 2, "active" => 'on',"description"=> 'fileserver, runs with SMB', "created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1],
            ["id" => 3, "name" => 'ExeApplication', "category_id" => 3, "active" => 'on',"description"=> 'exe application example', "created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1],
            ["id" => 4, "name" => 'Web App', "category_id" => 4, "active" => 'on',"description"=> 'Web App', "created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1],
            
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nodes');
    }
}
