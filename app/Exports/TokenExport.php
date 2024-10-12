<?php

namespace App\Exports;

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
        return Token::whereExportHistoryId($this->historyId)->get();
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

    public function map($row): array
    {
        return [
            $row->game->name,
            "",
            $row->token,
            $row->created_at,
        ];
    }

}
