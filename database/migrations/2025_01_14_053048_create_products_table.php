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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_tamil');
            $table->string('name_english')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('hsn_code')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('gst_slab', ['5', '12', '18'])->default('18');
            $table->string('barcode')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
