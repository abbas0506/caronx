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
        Schema::create('paper_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_title', 100)->nullable();
            $table->unsignedTinyInteger('type_id'); //mcq, short, long, numerical
            $table->unsignedTinyInteger('sr')->default(1);
            $table->unsignedTinyInteger('difficulty_level')->default(1);
            $table->unsignedTinyInteger('marks')->default(0);
            $table->unsignedTinyInteger('compulsory_parts')->default(0);
            $table->unsignedTinyInteger('display_style')->default(1); //horizontal, vertical
            $table->string('number_style', 10)->default('alpha');   //alpha, numeric, roman, urdu

            $table->foreignId('paper_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paper_questions');
    }
};
