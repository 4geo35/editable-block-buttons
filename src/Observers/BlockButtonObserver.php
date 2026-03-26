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
            ->where("item_id", $button->item_id)
            ->max("priority");
        if (empty($priority)) { $priority = 0; }
        $button->priority = $priority + 1;
    }
}
