<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();

            $table->foreignId('report_id')
                ->constrained('reports')
                ->cascadeOnDelete();

            $table->foreignId('claim_id')
                ->constrained('claims')
                ->cascadeOnDelete();

            $table->foreignId('returned_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('received_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->dateTime('returned_at');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique('claim_id');
            $table->index('report_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};