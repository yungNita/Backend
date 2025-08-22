<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('upcoming_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->constrained('media')->onDelete('cascade');
            $table->string('title');
            $table->text('detail');

            $table->dateTime('start_date');
            $table->dateTime('end_date');

            $table->string('location');
            $table->integer('num_participate')->nullable();
            $table->string('organizer')->nullable();
            $table->string('contact')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('upcoming_events');
    }
};
