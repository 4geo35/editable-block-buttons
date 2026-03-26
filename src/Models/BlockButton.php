<?php

namespace GIS\EditableBlockButtons\Models;

use GIS\EditableBlockButtons\Interfaces\BlockButtonModelInterface;
use GIS\EditableBlocks\Models\BlockItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlockButton extends Model implements BlockButtonModelInterface
{
    protected $fillable = [
        "title",
        "link",
        "event",
        "is_outline",
        "color",
    ];

    public function item(): BelongsTo
    {
        $blockItemModelClass = config("editable-blocks.customBlockItemModel") ?? BlockItem::class;
        return $this->belongsTo($blockItemModelClass, "item_id");
    }
}
