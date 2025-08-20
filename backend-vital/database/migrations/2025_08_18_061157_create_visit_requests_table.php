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
        Schema::create('visit_requests', function (Blueprint $table) {
            $table->id('visit_id');
            $table->string('visit_firstname');
            $table->string('visit_lastname');
            $table->string('visit_email');
            $table->string('visit_phNum');
            $table->string('visit_institute');
            $table->string('visit_purpose');
            $table->integer('number_of_visitors');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_requests');
    }
};
