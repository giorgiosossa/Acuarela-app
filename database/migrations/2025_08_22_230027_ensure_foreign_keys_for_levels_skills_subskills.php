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
        // Actualizar tabla skills si no tiene las columnas correctas
        if (!Schema::hasColumn('skills', 'level_id')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->foreignId('level_id')
                    ->constrained('levels')
                    ->onDelete('cascade');
            });
        }

        if (!Schema::hasColumn('skills', 'index')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->integer('index')->default(1);
            });
        }

        // Actualizar tabla sub_skills si no tiene las columnas correctas
        if (!Schema::hasColumn('sub_skills', 'skill_id')) {
            Schema::table('sub_skills', function (Blueprint $table) {
                $table->foreignId('skill_id')
                    ->constrained('skills')
                    ->onDelete('cascade');
            });
        }

        // Actualizar tabla levels si no tiene program_id
        if (!Schema::hasColumn('levels', 'program_id')) {
            Schema::table('levels', function (Blueprint $table) {
                $table->foreignId('program_id')
                    ->constrained('programs')
                    ->onDelete('cascade');
            });
        }

        // Crear índices para mejorar el rendimiento
        Schema::table('skills', function (Blueprint $table) {
            $table->index(['level_id', 'index']);
        });

        Schema::table('sub_skills', function (Blueprint $table) {
            $table->index('skill_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropIndex(['level_id', 'index']);
            $table->dropForeign(['level_id']);
            $table->dropColumn(['level_id', 'index']);
        });

        Schema::table('sub_skills', function (Blueprint $table) {
            $table->dropIndex(['skill_id']);
            $table->dropForeign(['skill_id']);
            $table->dropColumn('skill_id');
        });

        Schema::table('levels', function (Blueprint $table) {
            $table->dropForeign(['program_id']);
            $table->dropColumn('program_id');
        });
    }
};
