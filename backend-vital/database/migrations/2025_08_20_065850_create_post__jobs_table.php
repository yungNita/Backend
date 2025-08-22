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
        Schema::create('post__jobs', function (Blueprint $table) {
            $table->id('job_id');
            $table->string('position');
            $table->string('salary');
            $table->string('location');
            $table->enum('working_shift', ['full-time', 'part-time-morning', 'part-time-afternoon', 'remote'])->default('full-time');
            $table->longText('job_detail');
            $table->enum('employment_type', ['employee', 'intern', 'volunteer', 'young professional'])->default('employee');
            $table->string('department');
            $table->string('company');
            $table->dateTime('published_at')->nullable()->default(null);
            $table->foreignId('published_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('set null');
            $table->softDeletes();
            $table->foreignId('job_updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('set null');
            $table->enum('status', ['draft', 'published', 'scheduled', 'closed'])->default('draft');
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->boolean('is_available')->default(false);
            $table->dateTime('deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post__jobs');
    }
};
