<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request for updating stock
 */
class UpdateStockRequest extends FormRequest
{
    /**
     * Authorize the request (add RBAC logic here if needed)
     */
    public function authorize(): bool
    {
        // TODO: Add user/role-based authorization
        return true;
    }

    /**
     * Validation rules for updating stock
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'item_id' => ['required', 'uuid', 'exists:stock_items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
