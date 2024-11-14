<?php

namespace App\Exports;

use App\Models\Sku;
use App\Models\Token;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

readonly class TokenExport implements FromCollection, WithHeadings, WithMapping
{


    public function __construct(private int $historyId)
    {

    }
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Token::whereDumpHistoryId($this->historyId)->get();
    }

    public function headings(): array
    {
        return [
            "Game",
            "SKU",
            "Token",
            "Time",
        ];
    }

    /**
     * @param Token $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->sku->game_name,
            $row->sku->product_id,
            $row->purchase_token,
            $row->created_at,
        ];
    }

}
