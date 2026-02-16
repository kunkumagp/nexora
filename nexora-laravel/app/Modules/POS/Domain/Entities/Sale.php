<?php

namespace App\Modules\POS\Domain\Entities;

class Sale
{
    public string $id;
    public string $item_id;
    public int $quantity;
    public string $branch_id;
    public string $user_id;
    public string $created_at;

    public function __construct(string $id, string $item_id, int $quantity, string $branch_id, string $user_id, string $created_at)
    {
        $this->id = $id;
        $this->item_id = $item_id;
        $this->quantity = $quantity;
        $this->branch_id = $branch_id;
        $this->user_id = $user_id;
        $this->created_at = $created_at;
    }
}
