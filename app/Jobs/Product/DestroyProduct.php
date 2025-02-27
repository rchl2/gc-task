<?php

namespace App\Jobs\Product;

use App\Models\Product;

final class DestroyProduct
{
	/**
	 * Product.
	 *
	 * @var Product
	 */
	private $product;

	/**
	 * Create a new job instance.
	 */
	public function __construct(Product $product)
	{
		$this->product = $product;
	}

	/**
	 * Execute the job.
	 */
	public function handle(): bool
	{
		return $this->product->delete();
	}
}
