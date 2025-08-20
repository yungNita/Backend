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
            $table->string('deadline');
            $table->enum('working_shift', ['full-time', 'part-time-morning', 'part-time-afternoon', 'remote'])->default('full-time');
            $table->longText('job_detail');
            $table->enum('employment_type', ['employee', 'intern', 'volunteer', 'young professional'])->default('employee');
            $table->string('department');
            $table->string('company');
            $table->timestamp('published_at')->default(now());
            $table->foreignId('published_by')->constrained('users', 'id')->onUpdate('cascade');
            $table->timestamp('job_deleted_at')->nullable();
            $table->softDeletes();
            $table->timestamp('job_updated_at')->nullable();
            $table->foreignId('job_updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade');
            $table->enum('status', ['draft', 'published', 'scheduled', 'closed'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('closed_at')->nullable();
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
