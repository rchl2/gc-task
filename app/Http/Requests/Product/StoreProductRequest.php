<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

final class StoreProductRequest extends FormRequest
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
			'name'        => ['required', 'string', 'max:120'],
			'description' => ['nullable', 'string'],
			'price'       => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
			'rank'        => ['required', 'integer', 'min:0'],
			'stock'       => ['required', 'integer', 'min:0'],

			'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
		];
	}
}
