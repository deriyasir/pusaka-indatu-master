<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // AUTHOR ID
        // JUDUL
        // HEADLINE
        // CATEGORY [ RECIPE, POST ]
        // PRODUCT ID ( NULLABLE )
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('headline');
            $table->enum('category', ['resep', 'artikel']);
            $table->text('content');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->string('image');
            $table->integer('views')->default(0);
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
        Schema::dropIfExists('blogs');
    }
};
