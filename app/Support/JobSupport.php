<?php

namespace App\Support;

use Illuminate\Support\Arr;

trait JobSupport
{
	/**
	 * Preapre request fields from given request data.
	 */
	protected function prepareRequestFields(array $data, array $allowedData): array
	{
		return Arr::only($data, $allowedData);
	}
}
