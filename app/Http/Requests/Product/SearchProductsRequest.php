<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

final class SearchProductsRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'search'   => ['nullable', 'string', 'max:100'],
			'page'     => ['nullable', 'integer', 'min:1'],
			'perPage'  => ['nullable', 'integer', 'in:5,10,15,20'],
		];
	}

	/**
	 * Prepare the data for validation.
	 */
	protected function prepareForValidation(): void
	{
		$this->merge([
			'search'  => $this->search ?? '',
			'perPage' => $this->perPage ?? 5,
			'page'    => $this->page ?? 1,
		]);
	}
}
