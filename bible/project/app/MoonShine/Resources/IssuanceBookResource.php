<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Enums\BookTypeEnum;
use App\Enums\TypeConsumerEnum;
use App\Models\IssuanceBook;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<IssuanceBook>
 */
class IssuanceBookResource extends ModelResource
{
    protected string $model = IssuanceBook::class;

    protected string $title = 'IssuanceBooks';
    protected bool $createInModal = true;
    protected bool $editInModal = true;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {

        return [
            BelongsTo::make('Номер формуляра', 'form', 'id', resource: GroupResource::class)
                ->nullable()
                ->searchable(),

            BelongsTo::make(
                'Информационный ресурс',
                'informationResource',
                formatted: fn($ir) => "({$ir->id}) | {$ir->name}",
                resource: InformationResourceResource::class
            )
                ->required()
                ->searchable(),

            Select::make('Кому выдана', 'consumer')
                ->options(TypeConsumerEnum::options())
                ->required(),

            Text::make('Инициалы', 'initial')->required(),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                BelongsTo::make('Номер формуляра', 'form', 'number', resource: GroupResource::class)
                    ->required()
                    ->searchable(),

                BelongsTo::make(
                    'Информационный ресурс',
                    'informationResource',
                    formatted: fn($ir) => "({$ir->id}) | {$ir->name}",
                    resource: InformationResourceResource::class
                )
                    ->required()
                    ->searchable(),

                Select::make('Кому выдана', 'consumer')
                    ->options(TypeConsumerEnum::options())
                    ->required(),

                Text::make('Инициалы', 'initial')->required(),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    /**
     * @param IssuanceBook $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }
}
