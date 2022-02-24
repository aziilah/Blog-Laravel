<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            //tambah sendiri
            $table->foreignId('category_id'); //FK utk table Category
            $table->foreignId('user_id'); //FK utk table User
            $table->string('title');
            $table->string('slug')->unique(); //xda boleh slug yg sama..sebab dia url
            $table->string('image')->nullable();  //string utk simpan nama dan tempat simpan file //file duupload di directory
            $table->text('excerpt');
            $table->text('body');
            $table->timestamp('published_at')->nullable(); //bila posting dipublish
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
        Schema::dropIfExists('posts');
    }
}
