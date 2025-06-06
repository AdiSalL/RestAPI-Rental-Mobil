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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->decimal("price", 10, 2);
            $table->string("color");
            $table->enum("status", ["available", "booked", "maintanance"]);
            $table->integer("seat");
            $table->integer("cc");
            $table->integer("top_speed");
            $table->text("description");
            $table->string("location");
            $table->string("image_url");
            $table->unsignedBigInteger("category_id");
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
