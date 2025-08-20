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
        Schema::create('contact__messages', function (Blueprint $table) {
            $table->id('message_id');
            $table->string('message_firstname');
            $table->string('message_lastname');
            $table->string('message_email');
            $table->string('message_phNum');
            $table->text('message_detail');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact__messages');
    }
};
