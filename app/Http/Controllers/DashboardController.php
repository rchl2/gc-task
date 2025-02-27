<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Queries\ProductQueries;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\Product\SearchProductsRequest;

final class DashboardController extends Controller
{
	/**
	 * Show products index.
	 *
	 * This page allows ALL users to browse freely all the products in the storage.
	 */
	public function showProductsDashboard(SearchProductsRequest $request): Response
	{
		$products = ProductQueries::search($request->input('search'), $request->input('perPage'));

		return Inertia::render('PublicProducts', [
			'products' => $products,
			'canLogin' => Route::has('login'),
			'filters'  => $request->only(['search', 'perPage']),
		]);
	}

	/**
	 * Show authorized dashboard page.
	 *
	 * @return void
	 */
	public function showAuthorizedDashboard(): Response
	{
		return Inertia::render('Dashboard');
	}
}
