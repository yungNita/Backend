<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['activity', 'gallery', 'knowledge', 'article', 'upcoming_event'])-> default('article');
            
            $table->string('title');
            $table->string('thumbnail_img');

            $table->enum('source', ['facebook', 'instagram', 'youtube', 'education', 'culture', 'society', 'health', 'sport', 'environment'])->default('facebook');
            $table->enum('status', ['draft', 'schedule', 'published', 'archived'])->default('draft');
            
            $table->timestamps('scheduled_at')->nullable();
            $table->timestamps('published_at')->nullable();


            // track by admin
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('created_by_username')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->string('modified_by_username')->nullable();

            $table->timestamps(); 
            $table->softDeletes();

            $table->foreignId('users_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
