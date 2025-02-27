<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Product;
use App\Queries\ProductQueries;
use App\Jobs\Product\CreateProduct;
use App\Jobs\Product\UpdateProduct;
use App\Jobs\Product\DestroyProduct;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Product\SearchProductsRequest;

final class ProductController extends Controller
{
	/**
	 * Display index of products.
	 */
	public function index(SearchProductsRequest $request): Response
	{
		$products = ProductQueries::search($request->input('search'), $request->input('perPage'));

		return Inertia::render('Product/Index', [
			'products' => $products,
			'filters'  => $request->only(['search', 'perPage']),
		]);
	}

	/**
	 * Show the form for creating new product.
	 */
	public function create()
	{
		return Inertia::render('Product/Create');
	}

	/**
	 * Store product.
	 *
	 * @return void
	 */
	public function store(StoreProductRequest $request)
	{
		// Dispatch job to create product.
		$this->dispatchSync(new CreateProduct($request->validated()));

		// Redirect user.
		return Inertia::location(route('products.index'));
	}

	/**
	 * Show the form for updating product.
	 */
	public function edit(Product $product)
	{
		return Inertia::render('Product/Edit', ['product' => $product]);
	}

	/**
	 * Update product.
	 *
	 * @return void
	 */
	public function update(UpdateProductRequest $request, Product $product)
	{
		// Dispatch job to create product.
		$this->dispatchSync(new UpdateProduct($product, $request->validated()));

		// Redirect user.
		return Inertia::location(route('products.index'));
	}

	/**
	 * Destroy product.
	 */
	public function destroy(Product $product)
	{
		// Dispatch job to destroy product.
		$this->dispatchSync(new DestroyProduct($product));

		// Redirect user.
		return Inertia::location(route('products.index'));
	}
}
