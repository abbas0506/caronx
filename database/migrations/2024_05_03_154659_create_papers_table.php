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
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('chapter_ids', 200)->nullable(); //comma separted list of source chapters
            $table->string('title', 100)->nullable();
            $table->string('institution', 100)->nullable();
            $table->date('paper_date');
            $table->unsignedTinyInteger('duration')->default(0); //in munites
            $table->boolean('is_printed')->default(0); //in munites

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('papers');
    }
};
