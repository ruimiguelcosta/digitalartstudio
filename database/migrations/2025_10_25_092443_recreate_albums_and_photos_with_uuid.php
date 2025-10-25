<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('photos');
        Schema::dropIfExists('albums');

        Schema::create('albums', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('event_start_date')->nullable();
            $table->date('event_end_date')->nullable();
            $table->string('slug')->unique();
            $table->boolean('is_public')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('photos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('filename');
            $table->string('original_filename');
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->string('path');
            $table->string('url');
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->uuid('album_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
        Schema::dropIfExists('albums');

        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('event_start_date')->nullable();
            $table->date('event_end_date')->nullable();
            $table->string('slug')->unique();
            $table->boolean('is_public')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('filename');
            $table->string('original_filename');
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->string('path');
            $table->string('url');
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->foreignId('album_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
};
