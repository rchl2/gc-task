<?php

namespace App\Jobs\Product;

use App\Models\Product;
use App\Support\JobSupport;

final class UpdateProduct
{
	use JobSupport;

	/**
	 * Product.
	 *
	 * @var Product
	 */
	private $product;

	/**
	 * Product data.
	 *
	 * @var array
	 */
	private $productData;

	/**
	 * Create a new job instance.
	 */
	public function __construct(Product $product, array $productData)
	{
		$this->product = $product;
		$this->productData = $this->prepareRequestFields($productData, ['name', 'description', 'price', 'stock', 'rank']);
	}

	/**
	 * Execute the job.
	 */
	public function handle(): Product
	{
		$product = $this->product->update($this->productData);

		return $this->product;
	}
}
