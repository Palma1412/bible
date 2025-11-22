<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Enums\BookTypeEnum;
use App\Enums\UnitEnum;
use App\Models\InformationResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<InformationResource>
 */
class InformationResourceResource extends ModelResource
{
    protected string $model = InformationResource::class;

    protected string $title = 'information_resources';
    protected bool $createInModal = true;
    protected bool $editInModal = true;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            Text::make('Номер книги', 'id')->required(),
            Text::make('Название', 'name')->required(),
            Text::make('Автор', 'author')->required(),
            Select::make('Раздел', 'type')
                ->options(
                    collect(BookTypeEnum::cases())
                        ->mapWithKeys(fn(BookTypeEnum $type) => [$type->value => $type->label()])
                        ->toArray()
                )
                ->required()
        ->nullable(),

            Date::make('Дата поступления', 'delivery_date'),
            Date::make('Дата списания', 'debit_date'),
            Text::make('Статус выдачи', 'status'),
            Text::make('Статус списания', 'write_off_status'),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                Text::make('Номер книги', 'id')->required(),
                Text::make('Название', 'name')->required(),
                Text::make('Автор', 'author')->required(),
                Select::make('Раздел', 'type')
                    ->options(BookTypeEnum::options())
                    ->required(),
                Date::make('Дата поступления', 'delivery_date'),
                // Date::make('Дата списания', 'debit_date')->readonly(),
                Text::make('Статус выдачи', 'status')->readonly(),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            // Text::make('Номер книги', 'id')->required(),
            // Text::make('Название', 'name')->required(),
            // Text::make('Автор', 'author')->required(),
            // Select::make('Раздел', 'type')
            //     ->options(BookTypeEnum::options())
            //     ->required(),
            // Date::make('Дата поступления', 'delivery_date'),
            // Date::make('Дата списания', 'debit_date')
        ];
    }

    /**
     * @param InformationResource $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }


}
