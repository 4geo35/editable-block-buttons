<?php

use GIS\EditableBlocks\Models\BlockItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use GIS\EditableBlockButtons\Models\BlockButton;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('block_buttons', function (Blueprint $table) {
            $table->unsignedBigInteger("buttonable_id")->nullable()->after("id");
            $table->string("buttonable_type")->nullable()->after("buttonable_id");
        });

        if (config("editable-blocks")) {
            $buttons = BlockButton::query()->get();
            $blockItemModelClass = config("editable-blocks.customBlockItemModel") ?? BlockItem::class;
            foreach ($buttons as $button) {
                $button->buttonable_id = $button->item_id;
                $button->buttonable_type = $blockItemModelClass;
                $button->save();
            }
        }

        Schema::table('block_buttons', function (Blueprint $table) {
            $table->dropColumn("item_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('block_buttons', function (Blueprint $table) {
            $table->unsignedBigInteger("item_id")->nullable()->after("id");
        });

        if (config("editable-blocks")) {
            $buttons = BlockButton::query()->get();
            foreach ($buttons as $button) {
                $button->item_id = $button->buttonable_id;
                $button->save();
            }
        }

        Schema::table('block_buttons', function (Blueprint $table) {
            $table->dropColumn("buttonable_id");
            $table->dropColumn("buttonable_type");
        });
    }
};
