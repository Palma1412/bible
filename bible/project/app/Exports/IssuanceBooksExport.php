<?php

namespace App\Exports;

use App\Models\IssuanceBook;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IssuanceBooksExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $from;
    protected $to;

    public function __construct($from = null, $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * Возвращает коллекцию для экспорта
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = IssuanceBook::query()->with(['book', 'user']);

        if ($this->from && $this->to) {
            // если у тебя в форме даты в формате d.m.Y, возможно нужно преобразовать в Y-m-d
            $query->whereBetween('created_at', [$this->from, $this->to]);
        }

        return $query->get();
    }

    /**
     * Заголовки колонок
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Название книги',
            'Кому выдана',
            'Дата выдачи',
            'Дата возврата',
        ];
    }

    /**
     * Как маппить одну модель в строку Excel
     *
     * @param \App\Models\IssuanceBook $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->book->title ?? '-',
            $row->user->name ?? '-',
            $row->created_at?->format('Y-m-d H:i:s') ?? $row->created_at,
            $row->updated_at?->format('Y-m-d H:i:s') ?? $row->updated_at,
        ];
    }
}
