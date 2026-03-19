<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete();
            $table->string('destination');
            $table->unsignedInteger('days');
            $table->unsignedInteger('travelers');
            $table->string('budget_mode', 20)->default('both');
            $table->decimal('total_budget', 12, 2)->nullable();
            $table->json('category_budgets')->nullable();
            $table->json('daily_plan')->nullable();
            $table->text('summary')->nullable();
            $table->json('tips')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
