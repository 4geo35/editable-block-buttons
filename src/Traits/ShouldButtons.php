<?php

namespace GIS\EditableBlockButtons\Traits;

use GIS\EditableBlockButtons\Interfaces\ShouldButtonsInterface;
use GIS\EditableBlockButtons\Models\BlockButton;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ShouldButtons
{
    protected static function bootShouldButtons(): void
    {
        static::deleted(function (ShouldButtonsInterface $model) {
            $model->clearButtons();
        });
    }

    public function getButtonModelClassAttribute(): string
    {
        return config("editable-block-buttons.customBlockButtonModel") ?? BlockButton::class;
    }

    public function buttons(): MorphMany
    {
        return $this->morphMany($this->button_model_class, "buttonable");
    }

    public function orderedButtons(): MorphMany
    {
        return $this->buttons()->orderBy("priority");
    }

    public function clearButtons(): void
    {
        foreach ($this->buttons as $button) {
            $button->delete();
        }
    }
}
