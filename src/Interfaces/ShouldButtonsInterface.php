<?php

namespace GIS\EditableBlockButtons\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ShouldButtonsInterface
{
    public function buttons(): MorphMany;
    public function orderedButtons(): MorphMany;

    public function clearButtons(): void;
}
