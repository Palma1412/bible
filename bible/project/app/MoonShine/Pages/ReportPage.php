<?php
// app/MoonShine/Pages/ReportPage.php

namespace App\MoonShine\Pages;

use App\Models\InformationResource;
use App\Models\IssuanceBook;
use App\Models\User;
use App\Models\Group;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Support\Enums\FormMethod;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Fields\DateRange;
use PhpParser\Node\Stmt\Block;


class ReportPage extends Page
{
    public string $title = 'Отчет по датам';
    public string $uriKey = 'reports';

    public function components(): array
    {
        return [
            FormBuilder::make()
                ->method(FormMethod::POST)
                ->action(route('reports.generate'))
                ->fields([
                    DateRange::make('Период', 'period')
                        ->format('Y-m-d')
                        ->hint('Выберите диапазон дат для формирования отчета'),
                ])
                ->submit('Сформировать Excel отчет'),
        ];
    }
}
