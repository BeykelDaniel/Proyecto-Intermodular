<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amigos', function (Blueprint $table) {
            $table->id();
            // El usuario que envía la solicitud (friendRequestsSent)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // El usuario que recibe la solicitud (friendRequestsReceived)
            $table->foreignId('amigo_id')->constrained('users')->onDelete('cascade');
            // Estado de la relación: 'pendiente', 'aceptada', 'rechazada'
            $table->enum('status', ['pendiente', 'aceptada', 'rechazada'])->default('pendiente');
            $table->timestamps();

            // Evita duplicados: no puede haber dos filas para la misma pareja de usuarios
            $table->unique(['user_id', 'amigo_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('amigos');
    }
};