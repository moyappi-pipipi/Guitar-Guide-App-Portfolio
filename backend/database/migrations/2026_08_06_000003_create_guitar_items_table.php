<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guitar_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->string('category'); // pick | capo | tuner | string | strap
            $table->unsignedInteger('price');
            $table->string('specs')->nullable();
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->boolean('is_recommended')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guitar_items');
    }
};
