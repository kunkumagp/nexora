<?php

namespace App\Modules\POS\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_id' => 'required|uuid|exists:stock_items,id',
            'quantity' => 'required|integer|min:1',
            'branch_id' => 'required|uuid',
            'user_id' => 'required|uuid',
        ];
    }
}
