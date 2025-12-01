/** MIGRACION TABLA DE PREGUNTAS 
SE PUEDE CREAR LAS PREGUNTAS QUE PERTENECEN A CADA ENCUESTA Y VA A TENER 3 OPCIONES 
OPCION MULTIPLE O UNICA Y TEXTO LIBRE 
*/


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //Crea la tabla questions  con sus respectivas columnas 
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); // ID unico de cada encesta 
            $table->foreignId('survey_id')->constrained()->onDelete('cascade');//relacion con encuesta(si se borra la encuesta se borran las pregutnas)
            $table->text('question');// texto de la pregunta 
            $table->enum('type', ['text', 'select', 'checkbox']);//tipo de pregunta
            $table->timestamps();
        });
    }
/**
 *Se elimina la tbal questions 
*/
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};