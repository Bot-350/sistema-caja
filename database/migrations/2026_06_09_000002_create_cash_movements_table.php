<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cash_movements')) {
            Schema::table('cash_movements', function (Blueprint $table) {
                if (! Schema::hasColumn('cash_movements', 'reason')) {
                    $table->string('reason')->nullable();
                }

                if (! Schema::hasColumn('cash_movements', 'description')) {
                    $table->string('description')->nullable();
                }
            });

            return;
        }

        Schema::create('cash_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_register_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 8, 2);
            $table->string('reason');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_movements');
    }
};