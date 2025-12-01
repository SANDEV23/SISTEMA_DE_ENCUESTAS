/** MIGRACION TABLA SURVEYS 
crea la tabla principal de encuestas del sistema y nos permite asociarlo 
a una empresa y contiene un titulo y una descripcion 
*/
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**crea la tabla surveys 
    */
    public function up(): void
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id(); /**ID UNICO DE CADA ENCUENTA  */
            $table->foreignId('company_id')->constrained()->onDelete('cascade');//RELACION CON CADA EMPRESA
            $table->string('title'); //Titulo de la encuesta 
            $table->text('description')->nullable();// Descripcion de la encuesta 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};