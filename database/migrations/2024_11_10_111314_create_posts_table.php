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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->integer('status')->default(1);
            $table->json('categories')->nullable(); // Add this to store multiple category IDs
            $table->json('sub_categories')->nullable();
            $table->json('tags')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->longText('short_description')->nullable();
            $table->enum('is_featured', ['Yes', 'No'])->default('No');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
