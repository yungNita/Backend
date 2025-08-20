<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->constrained('media')->onDelete('cascade');
            $table->string('url'); // facebook / instagram / youtube link
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_links');
    }
};
