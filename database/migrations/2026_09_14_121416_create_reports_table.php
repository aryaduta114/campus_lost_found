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
    Schema::create('reports', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('category_id')
            ->constrained()
            ->restrictOnDelete();

        $table->foreignId('location_id')
            ->constrained()
            ->restrictOnDelete();

        $table->enum('type', ['LOST', 'FOUND']);

        $table->string('title', 150);
        $table->text('description');

        $table->string('brand', 100)->nullable();
        $table->string('color', 50)->nullable();

        $table->date('event_date');

        $table->enum('status', [
            'PENDING',
            'APPROVED',
            'REJECTED',
            'CLAIMED',
            'RETURNED',
            'CLOSED',
        ])->default('PENDING');

        $table->string('contact_info', 255)->nullable();

        $table->timestamps();

        $table->index(['type', 'status']);
        $table->index('event_date');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};