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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('position_name');
            $table->string('ph_num');  
            $table->string('email');
            $table->string('cv_file');
            $table->longText('remark')->nullable();
            $table->timestamp('date_applied')->useCurrent();
            $table->string('department')->nullable();
            $table->string('company')->nullable();
            $table->string('other_file')->nullable();
            $table->enum('status', ['under_review', 'interview', 'offer', 'rejected', 'accepted'])->default('under_review');
            // $table->foreignId('job_id')->nullable()->constrained('post_job')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
