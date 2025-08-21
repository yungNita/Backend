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
        Schema::create('project_proposals', function (Blueprint $table) {
            $table->bigIncrements('project_id');
            $table->string('project_firstname');
            $table->string('project_lastname');
            $table->string('project_email');
            $table->string('project_phNum');
            $table->string('project_projectName');
            $table->string('project_detail');
            $table->string('project_file')->nullable();
            $table->enum('status', ['pending','approved','rejected','completed'])->default('pending');
            $table->foreignId('project_updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_proposals');
    }
};
