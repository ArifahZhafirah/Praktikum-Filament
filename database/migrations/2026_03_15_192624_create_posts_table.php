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
            $table->String('title');
            $table->String('slug');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->String('color')->nullable();
            $table->String('image')->nullable();
            $table->text('body')->nullable();
            $table->boolean('published')->default(false);
            $table->date('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('post_tag', function (Blueprint $table) {
        $table->foreignId('post_id')
            ->constrained()
            ->cascadeOnDelete();
        $table->foreignId('tag_id')
            ->constrained()
            ->cascadeOnDelete();
        $table->primary(['post_id', 'tag_id']);
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
