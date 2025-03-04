<?php

namespace App\Queries;

use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;

final class ProductQueries
{
	/**
	 * Search through products.
	 */
	public static function search(?string $phrase, int $perPage = 5): Paginator
	{
		return Product::query()
			->when($phrase, function ($query, $phrase) {
				$query->where('name', 'like', "%{$phrase}%");
			})
			->latest('created_at')
			->paginate($perPage);
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
