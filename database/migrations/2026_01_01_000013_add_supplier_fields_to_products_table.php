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
        Schema::table('products', function (Blueprint $table) {
            $table->string('supplier_name')->nullable()->after('platform_name');
            $table->text('supplier_url')->nullable()->after('supplier_name');
            $table->decimal('supplier_cost', 10, 2)->nullable()->after('supplier_url');
            $table->string('supplier_contact')->nullable()->after('supplier_cost');
            $table->string('supplier_sku')->nullable()->after('supplier_contact');
            $table->text('supplier_notes')->nullable()->after('supplier_sku');
            $table->string('short_code', 32)->nullable()->unique()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'supplier_name',
                'supplier_url',
                'supplier_cost',
                'supplier_contact',
                'supplier_sku',
                'supplier_notes',
                'short_code',
            ]);
        });
    }
};
