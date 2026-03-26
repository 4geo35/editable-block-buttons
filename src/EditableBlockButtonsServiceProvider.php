<?php

namespace GIS\EditableBlockButtons;

use GIS\EditableBlockButtons\Models\BlockButton;
use GIS\EditableBlockButtons\Observers\BlockButtonObserver;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use GIS\EditableBlockButtons\Livewire\Admin\Buttons\ListWire as AdminListWire;

class EditableBlockButtonsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . "/database/migrations");
        $this->mergeConfigFrom(__DIR__ . "/config/editable-block-buttons.php", 'editable-block-buttons');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . "/resources/views", "ebtns");

        $this->observeModels();

        $this->addLivewireComponents();
    }

    protected function addLivewireComponents(): void
    {
        $component = config("editable-block-buttons.customAdminListWireComponent");
        Livewire::component(
            "ebtns-btn-list",
            $component ?? AdminListWire::class
        );
    }

    protected function observeModels(): void
    {
        $modelClass = config("editable-block-buttons.customBlockButtonModel") ?? BlockButton::class;
        $observerClass = config("editable-block-buttons.customBlockButtonModelObserver") ?? BlockButtonObserver::class;
        $modelClass::observe($observerClass);
    }
}
