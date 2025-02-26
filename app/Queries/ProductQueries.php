<?php

namespace App\Queries;

use App\Models\Product;
use Illuminate\Pagination\Paginator;

final class ProductQueries
{
	/**
	 * Get the latest products with pagination.
	 *
	 * @param int $perPage number of products per page
	 *
	 * @return \Illuminate\Contracts\Pagination\Paginator
	 */
	public static function latestPaginated(int $perPage = 15): Paginator
	{
		return Product::latest('created_at')
			->simplePaginate($perPage);
	}

	/**
	 * Find a product by its primary key.
	 *
	 * @param int $id as the primary key
	 *
	 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public static function findByPrimaryKey(int $id): Product
	{
		return Product::findOrFail($id);
	}
}
