<?php
declare(strict_types=1);

namespace App\Modules\POS\Domain\Events;

class InvoiceCreated
{
    public string $invoiceId;
    public array $items;

    public function __construct(string $invoiceId, array $items)
    {
        $this->invoiceId = $invoiceId;
        $this->items = $items;
    }
}
