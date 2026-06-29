<?php

namespace GIS\EditableBlockButtons\Models;

use GIS\EditableBlockButtons\Interfaces\BlockButtonModelInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BlockButton extends Model implements BlockButtonModelInterface
{
    protected $fillable = [
        "title",
        "link",
        "event",
        "is_outline",
        "color",
    ];

    public function buttonable(): MorphTo
    {
        return $this->morphTo();
    }
}
