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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('tag');
            $table->text('description');
            $table->string('preview_color')->default('green');
            $table->string('icon')->default('✦');
            $table->string('preview_label');
            $table->string('preview_title');
            $table->boolean('is_dark_preview')->default(false);
            $table->text('long_description')->nullable();
            $table->json('features')->nullable();
            $table->json('audiences')->nullable();
            $table->json('tech_stack')->nullable();
            $table->json('pricing')->nullable();
            $table->json('faq')->nullable();
            $table->json('meta_pills')->nullable();
            $table->string('price_display')->nullable();
            $table->string('price_note')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
