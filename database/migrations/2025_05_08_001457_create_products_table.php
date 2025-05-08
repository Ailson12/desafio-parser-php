<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('unique product code')->unique(); //  (ex: código de barras)
            $table->string('product_name')->nullable();
            $table->string('brands')->nullable();
            $table->string('categories')->nullable();
            $table->string('image_url')->nullable();
            $table->text('ingredients_text')->nullable();
            $table->float('nutriments_energy')->comment('kcal')->nullable();
            $table->float('nutriments_fat')->nullable();
            $table->float('nutriments_saturated_fat')->nullable();
            $table->float('nutriments_sugars')->nullable();
            $table->float('nutriments_proteins')->nullable();
            $table->float('nutriments_salt')->nullable();

            // Campos personalizados
            $table->timestamp('imported_t')->comment('import datetime')->nullable();
            $table->enum('status', ['draft', 'published', 'trash'])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
