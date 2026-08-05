<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guitars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->unsignedInteger('price');
            $table->string('body_type'); // dreadnought | concert | mini | classical
            $table->string('level'); // beginner | intermediate | advanced
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->boolean('is_recommended')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guitars');
    }
};
