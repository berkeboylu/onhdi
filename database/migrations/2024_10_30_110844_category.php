<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Category extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('icon');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->integer('byuserid');
        });
        
        //Putting Example Data
        DB::table('category')->insert(
            ["id" => 1, "name" => 'Database', "icon" => '/database-default.png', "created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1],
            ["id" => 2, "name" => 'File Server', "icon" => '/folder.png', "created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1],
            ["id" => 3, "name" => 'Application', "icon" => '/exe.png', "created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1],
            ["id" => 7, "name" => 'Mobile App', "icon" => '/mobile.png', "created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1],
            ["id" => 8, "name" => 'WebApp', "icon" => '/webapp.png', "created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1],
            ["id" => 9, "name" => 'Server', "icon" => '/server.png', "created_at" => Carbon\Carbon::now(), "updated_at" => Carbon\Carbon::now(), "byuserid" => 1],
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
