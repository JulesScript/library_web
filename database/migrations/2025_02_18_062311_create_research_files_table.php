<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('research_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Reference to courses table
            $table->string('file_path'); // Path to the research file
            $table->string('file_name'); // Original file name
            $table->string('file_type'); // File type (e.g., pdf, docx)
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade'); // Who uploaded
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
