<?php

namespace App\Jobs\Product;

use App\Models\Product;
use App\Support\JobSupport;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

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
	 * Uploaded image file.
	 *
	 * @var UploadedFile|null
	 */
	private $image;

	/**
	 * Create a new job instance.
	 */
	public function __construct(array $productData)
	{
		$this->image = $productData['image'] ?? null;
		$this->productData = $this->prepareRequestFields($productData, ['name', 'description', 'price', 'stock', 'rank']);
	}

	/**
	 * Execute the job.
	 */
	public function handle(): Product
	{
		// Handle image, assign it into final product data array
		if ($this->image instanceof UploadedFile && $this->image->isValid()) {
			$fileName = Str::random(20).'.'.$this->image->getClientOriginalExtension();
			$this->productData['image'] = $this->image->storeAs('products', $fileName, 'public');
		}

		// Create product
		return Product::create($this->productData);
	}
}
