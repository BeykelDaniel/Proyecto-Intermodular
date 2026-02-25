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
    Schema::create('actividad_foto', function (Blueprint $table) {
        $table->id();
        $table->foreignId('actividad_id')->constrained('actividades')->onDelete('cascade');
        $table->foreignId('foto_id')->constrained('fotos')->onDelete('cascade');
        $table->timestamps();
    });
}
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividad_foto');
    }
};
