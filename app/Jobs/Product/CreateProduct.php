<?php

namespace App\Jobs\Product;

use App\Models\Product;
use App\Support\JobSupport;

final class CreateProduct
{
	use JobSupport;

	/**
	 * Product data.
	 *
	 * @var array
	 */
	private $productData;

	/**
	 * Create a new job instance.
	 */
	public function __construct(array $productData)
	{
		$this->productData = $this->prepareRequestFields($productData, ['name', 'description', 'price', 'stock', 'rank']);
	}

	/**
	 * Execute the job.
	 */
	public function handle(): Product
	{
		return Product::create($this->productData);
	}
}
