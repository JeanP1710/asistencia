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
        Schema::create('personals', function (Blueprint $table) {
            $table->id();
            $table->string('numero_dni',15)->unique();
            $table->string('nombres');
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->date('fecha_nacimiento')->default('2024-10-01');
            $table->string('telefono', 9)->nullable();
            $table->foreignId('tipo_trabajador_id')
            ->constrained('tipo_trabajadors')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('cargo')->default('ninguno');
            $table->string('email')->nullable();
            $table->unsignedTinyInteger('es_activo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personals');
    }
};
