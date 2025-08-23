<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->nullable()->constrained('media')->onDelete('cascade');
            $table->string('path');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_images');
    }
};
