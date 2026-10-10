<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 50)->unique();
            $table->string('name', 100);
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->decimal('price', 12, 2);
            $table->integer('stock')->default(0);
            $table->string('image_path', 255)->nullable();
            $table->timestamps();
        });
        
        // Add check constraint for price and stock manually since Laravel Schema builder doesn't have a direct check() method for all databases out of box, though it's supported via raw queries or DB::statement if needed.
        DB::statement('ALTER TABLE products ADD CONSTRAINT chk_price CHECK (price >= 0)');
        DB::statement('ALTER TABLE products ADD CONSTRAINT chk_stock CHECK (stock >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
