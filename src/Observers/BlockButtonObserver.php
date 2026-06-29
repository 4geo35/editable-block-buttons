<?php

namespace GIS\EditableBlockButtons\Observers;

use GIS\EditableBlockButtons\Interfaces\BlockButtonModelInterface;
use GIS\EditableBlockButtons\Models\BlockButton;

class BlockButtonObserver
{
    public function creating(BlockButtonModelInterface $button): void
    {
        $modelClass = config("editable-block-buttons.customBlockButtonModel") ?? BlockButton::class;
        $priority = $modelClass::query()
            ->select("id", "priority")
            ->where("buttonable_id", $button->buttonable_id)
            ->where("buttonable_type", $button->buttonable_type)
            ->max("priority");
        if (empty($priority)) { $priority = 0; }
        $button->priority = $priority + 1;
    }

    public function created(BlockButtonModelInterface $button): void
    {
        $button->buttonable()->touch();
    }

    public function updated(BlockButtonModelInterface $button): void
    {
        $button->buttonable()->touch();
    }

    public function deleted(BlockButtonModelInterface $button): void
    {
        $button->buttonable()->touch();
    }
}
