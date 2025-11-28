<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT

            // Must match users.id (bigint unsigned)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Must match products.id (bigint unsigned)
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
