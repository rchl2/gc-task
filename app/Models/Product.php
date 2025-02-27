<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Product extends Model
{
	use HasFactory;

	/**
	 * The attribuets that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'description', 'price', 'stock', 'rank', 'image',
	];

	/**
	 * The attribues that should be hidden for serialization.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * Get the attributes that should be cast.
	 */
	protected function casts(): array
	{
		return [
			'price' => 'decimal:2',
			'stock' => 'integer',
			'rank'  => 'integer',
		];
	}
}
