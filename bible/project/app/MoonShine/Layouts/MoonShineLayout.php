<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\InformationResourceResource;
use App\MoonShine\Resources\GroupResource;
use App\MoonShine\Resources\IssuanceBookResource;
use App\MoonShine\Pages\ReportPage;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Components\Fragment;
use MoonShine\Laravel\Layouts\CompactLayout;
use MoonShine\MenuManager\MenuItem;
use MoonShine\UI\Components\{Layout\Assets,
    Layout\Body,
    Layout\Burger,
    Layout\Content,
    Layout\Div,
    Layout\Flash,
    Layout\Head,
    Layout\Html,
    Layout\Layout,
    Layout\Menu,
    Layout\Meta,
    Layout\Sidebar,
    Layout\ThemeSwitcher,
    Layout\Wrapper,
    When};
use App\MoonShine\Resources\FormResource;

final class MoonShineLayout extends CompactLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            ...parent::menu(),
            MenuItem::make('Информационный ресурсы', InformationResourceResource::class),
            MenuItem::make('Группы', GroupResource::class),
            MenuItem::make('Выданные книги', IssuanceBookResource::class),
            MenuItem::make('Отчёты', ReportPage::class),
            MenuItem::make('Формуляры', FormResource::class),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    public function build(): Layout
    {
        return parent::build();
    }
}
