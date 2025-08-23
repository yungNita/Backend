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

            $table->enum('category', ['activity', 'gallery', 'knowledge', 'article', 'upcoming_event'])->default('article');
            
            $table->string('title');
            $table->string('thumbnail_img');

            $table->enum('source', ['facebook', 'instagram', 'youtube', 'education', 'culture', 'society', 'health', 'sport', 'environment'])->default('facebook');
            $table->enum('status', ['draft', 'schedule', 'published'])->default('draft');

            $table->string('url')->nullable(); // facebook / instagram / youtube link
            $table->longText('article_detail')->nullable();
            
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('published_at')->nullable();

            // Track by admin
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('created_by_username')->nullable();
            $table->foreignId('modified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('modified_by_username')->nullable();

            $table->timestamps(); 
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
