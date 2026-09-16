<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lost_report_id')
                ->constrained('reports')
                ->cascadeOnDelete();

            $table->foreignId('found_report_id')
                ->constrained('reports')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('score');

            $table->enum('status', [
                'SUGGESTED',
                'CONFIRMED',
                'REJECTED',
            ])->default('SUGGESTED');

            $table->timestamps();

            $table->unique([
                'lost_report_id',
                'found_report_id',
            ]);

            $table->index('score');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};