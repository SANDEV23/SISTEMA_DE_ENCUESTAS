/**
CREACION DE LA TABLA ANSWERS 
*/

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->onDelete('cascade');// Relacion con la encuesta 
            $table->foreignId('question_id')->constrained()->onDelete('cascade');//realcion con la pregunta
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();//relacion con el usuario 
            $table->text('answer');
            $table->timestamps();
        });
    }
/**
 * Elimina la tabla answers 
 */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};