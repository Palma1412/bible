<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\ClientResource;
use App\MoonShine\Resources\RoleResource;
use App\MoonShine\Resources\CompanyResource;
use App\MoonShine\Resources\RestaurantResource;
use App\MoonShine\Resources\RestaurantTranslationResource;
use App\MoonShine\Resources\LanguageResource;
use App\MoonShine\Resources\IngredientResource;
use App\MoonShine\Resources\CuisineResource;
use App\MoonShine\Resources\TagResource;
use App\MoonShine\Resources\InformationResourceResource;
use App\MoonShine\Resources\GroupResource;
use App\MoonShine\Resources\IssuanceBookResource;
use App\MoonShine\Pages\ReportPage;
use App\MoonShine\Resources\FormResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                InformationResourceResource::class,
                GroupResource::class,
                IssuanceBookResource::class,
                FormResource::class,
            ])
            ->pages([
                ...$config->getPages(),
                ReportPage::class,
            ])
        ;
    }
}
