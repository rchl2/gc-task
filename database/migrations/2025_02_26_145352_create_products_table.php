<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('products', function (Blueprint $table) {
			$table->id();

			$table->string('name', 120);
			$table->text('description')->nullable();

			$table->decimal('price', 10, 2);
			$table->integer('stock');
			$table->integer('rank');
			$table->string('image')->nullable();

			// Timestamps
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
