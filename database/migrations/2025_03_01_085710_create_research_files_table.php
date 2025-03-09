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
        Schema::create('research_files', function (Blueprint $table) {
            $table->id();
            // Reference to the courses table, adjust onDelete as needed
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type');
            // If uploaded_by references a users table, you might use foreignId as well
            $table->unsignedBigInteger('uploaded_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_files');
    }
};
