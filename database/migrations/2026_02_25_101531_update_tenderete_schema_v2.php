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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'perfil_foto')) {
                $table->string('perfil_foto')->nullable()->after('password');
            }
        });

        Schema::table('actividades', function (Blueprint $table) {
            if (!Schema::hasColumn('actividades', 'imagen')) {
                $table->string('imagen')->nullable()->after('cupos');
            }
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actividades_id')->constrained('actividades')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('contenido');
            $table->timestamps();
        });

        Schema::table('media', function (Blueprint $table) {
            if (!Schema::hasColumn('media', 'actividad_id')) {
                $table->foreignId('actividad_id')->nullable()->after('id')->constrained('actividades')->onDelete('cascade');
            }
            if (!Schema::hasColumn('media', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('actividad_id')->constrained('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
        
        Schema::table('media', function (Blueprint $table) {
            $table->dropForeign(['actividad_id']);
            $table->dropColumn('actividad_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('actividades', function (Blueprint $table) {
            $table->dropColumn('imagen');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('perfil_foto');
        });
    }
};
