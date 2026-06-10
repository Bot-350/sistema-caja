<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            if (! Schema::hasColumn('sales', 'subtotal')) {
                $table->decimal('subtotal', 8, 2)->default(0);
            }

            if (! Schema::hasColumn('sales', 'discount_percentage')) {
                $table->decimal('discount_percentage', 5, 2)->default(0);
            }

            if (! Schema::hasColumn('sales', 'discount_amount')) {
                $table->decimal('discount_amount', 8, 2)->default(0);
            }
        });

        if (Schema::hasColumn('sales', 'subtotal')) {
            DB::table('sales')
                ->where('subtotal', 0)
                ->update(['subtotal' => DB::raw('total')]);
        }
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'discount_amount')) {
                $table->dropColumn('discount_amount');
            }

            if (Schema::hasColumn('sales', 'discount_percentage')) {
                $table->dropColumn('discount_percentage');
            }

            if (Schema::hasColumn('sales', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
        });
    }
};