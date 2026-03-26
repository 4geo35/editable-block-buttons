<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('block_buttons', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("item_id");
            $table->string("title");
            $table->string("link")->nullable();
            $table->string("event")->nullable();

            $table->dateTime("is_outline")->nullable();
            $table->string("color")->nullable();

            $table->unsignedInteger("priority")->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('block_buttons');
    }
};
