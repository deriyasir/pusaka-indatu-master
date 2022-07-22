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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_order')->unique();
            $table->foreignId('address_id')->constrained('user_addresses')->onDelete('cascade');
            $table->string('kurir')->nullable();
            $table->string('service')->nullable();
            $table->string('etd')->nullable();
            $table->string('harga_ongkir')->nullable();
            $table->string('resi')->nullable();
            $table->integer('total');
            $table->enum('status', ['waiting', 'processing', 'sending', 'done', 'cancelled'])->default('waiting');
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
        Schema::dropIfExists('orders');
    }
};
