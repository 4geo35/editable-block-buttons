<?php

namespace GIS\EditableBlockButtons\Traits;

use GIS\EditableBlockButtons\Interfaces\ShouldButtonsInterface;
use GIS\EditableBlockButtons\Models\BlockButton;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

trait ShouldButtons
{
    protected static function bootShouldButtons(): void
    {
        static::deleted(function (ShouldButtonsInterface $model) {
            $model->clearButtons();
        });
    }

    public function buttons(): MorphMany
    {
        return $this->morphMany($this->button_model_class, "buttonable");
    }

    public function orderedButtons(): MorphMany
    {
        return $this->buttons()->orderBy("priority");
    }

    public function getButtonModelClassAttribute(): string
    {
        return config("editable-block-buttons.customBlockButtonModel") ?? BlockButton::class;
    }

    public function getModelHashAttribute(): string
    {
        $table = $this->getTable();
        return Str::limit(md5($table), 10, "");
    }

    public function clearButtons(): void
    {
        foreach ($this->buttons as $button) {
            $button->delete();
        }
    }
}
