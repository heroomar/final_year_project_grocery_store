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
            $table->string('name');
            $table->string('slug')->nullable();;
            $table->unsignedBigInteger('maincategory_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->integer('status')->default(1)->comment('0 => Inactive, 1 => Active');
            $table->float('price')->default(0);
            $table->float('sale_price')->default(0);
            $table->integer('product_stock')->default(0);
            $table->integer('product_weight')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->string('cover_image_url')->nullable();
            $table->string('stock_status')->default(0);
            $table->longText('description')->nullable();
            $table->text('detail')->nullable();
            $table->text('specification')->nullable();
            $table->string('theme_id')->nullable();
            $table->integer('store_id');
            $table->integer('created_by');
            
            $table->timestamps();

            $table->foreign('maincategory_id')->references('id')->on('main_categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onDelete('cascade');
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
