<?php

namespace GIS\EditableBlockButtons\Livewire\Admin\Buttons;

use GIS\EditableBlockButtons\Interfaces\BlockButtonModelInterface;
use GIS\EditableBlockButtons\Models\BlockButton;
use GIS\EditableBlocks\Interfaces\BlockItemModelInterface;
use GIS\EditableBlocks\Interfaces\BlockModelInterface;
use GIS\EditableBlocks\Traits\CheckBlockAuthTrait;
use Illuminate\View\View;
use Livewire\Component;

class ListWire extends Component
{
    use CheckBlockAuthTrait;

    public BlockItemModelInterface $blockItem;
    public BlockModelInterface $block;

    public array $formList = [];

    public bool $displayData = false;
    public bool $displayDelete = false;

    public int|null $btnId = null;

    public string $title = "";
    public string $link = "";
    public string $event = "";
    public bool $isOutline = false;
    public string $color = "";

    public function rules(): array
    {
        return [
            "title" => ["required", "string", "max:50"],
            "link" => ["nullable", "url", "max:255"],
            "event" => ["nullable", "string", "max:255"],
            "color" => ["nullable", "string", "max:255"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Заголовок",
            "link" => "Ссылка",
            "event" => "Форма",
            "color" => "Цвет",
        ];
    }

    public function mount(): void
    {
        $this->block = $this->blockItem->block;
        $this->formList = config("editable-block-buttons.forms");
    }

    public function render(): View
    {
        $buttons = $this->blockItem->orderedButtons;
        return view("ebtns::livewire.admin.buttons.list-wire", compact("buttons"));
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        $this->validate();

        $this->blockItem->buttons()->create([
            "title" => $this->title,
            "link" => $this->link,
            "event" => $this->event,
            "is_outline" => $this->isOutline ? now() : null,
            "color" => $this->color,
        ]);

        session()->flash("block-buttons-{$this->blockItem->id}-success", "Кнопка успешно добавлена");
        $this->closeData();
    }

    public function showEdit(int $modelId): void
    {
        $this->resetFields();
        $this->btnId = $modelId;
        $model = $this->findModel();
        if (! $model) { return; }
        if (! $this->checkAuth("update", true)) { return; }

        $this->title = $model->title;
        $this->link = $model->link;
        $this->event = $model->event;
        $this->isOutline = (bool) $model->is_outline;
        $this->color = $model->color;

        $this->displayData = true;
    }

    public function update(): void
    {
        $model = $this->findModel();
        if (! $model) { return; }
        if (! $this->checkAuth("update", true)) { return; }
        $this->validate();

        $model->update([
            "title" => $this->title,
            "link" => $this->link,
            "event" => $this->event,
            "is_outline" => $this->isOutline ? now() : null,
            "color" => $this->color,
        ]);

        session()->flash("block-buttons-{$this->blockItem->id}-success", "Кнопка успешно обновлена");
        $this->closeData();
    }

    public function closeDelete(): void
    {
        $this->resetFields();
        $this->displayDelete = false;
    }

    public function showDelete(int $modelId): void
    {
        $this->resetFields();
        $this->btnId = $modelId;
        $model = $this->findModel();
        if (! $model) { return; }
        if (! $this->checkAuth("delete", true)) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $model = $this->findModel();
        if (! $model) { return; }
        if (! $this->checkAuth("delete", $model)) { return; }

        try {
            $model->delete();
        } catch (\Exception $exception) {
            session()->flash("block-buttons-{$this->blockItem->id}-error", "Ошибка при удалении кнопки");
            $this->closeDelete();
            return;
        }

        session()->flash("block-buttons-{$this->blockItem->id}-success", "Кнопка успешно удалена");
        $this->closeDelete();
    }

    public function moveUp(int $btnId): void
    {
        $this->btnId = $btnId;
        $model = $this->findModel();
        if (! $model) { return; }
        if (! $this->checkAuth("update", true)) { return; }

        $previous = $this->blockItem->buttons()
            ->where("priority", "<", $model->priority)
            ->orderBy("priority", "desc")
            ->first();

        if ($previous) { $this->switchPriority($model, $previous); }
    }

    public function moveDown(int $btnId): void
    {
        $this->btnId = $btnId;
        $model = $this->findModel();
        if (! $model) { return; }
        if (! $this->checkAuth("update", true)) { return; }

        $previous = $this->blockItem->buttons()
            ->where("priority", ">", $model->priority)
            ->orderBy("priority")
            ->first();

        if ($previous) { $this->switchPriority($model, $previous); }
    }

    protected function switchPriority(BlockButtonModelInterface $item, BlockButtonModelInterface $target): void
    {
        $buff = $target->priority;
        $target->priority = $item->priority;
        $target->save();

        $item->priority = $buff;
        $item->save();
    }

    protected function resetFields(): void
    {
        $this->reset("btnId", "title", "link", "event", "isOutline", "color");
    }

    protected function findModel(): ?BlockButtonModelInterface
    {
        $modelClass = config("editable-block-buttons.customBlockButtonModel") ?? BlockButton::class;
        $model = $modelClass::query()->find($this->btnId);
        if (! $model) {
            session()->flash("block-buttons-{$this->blockItem->id}-error", "Кнопка не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $model;
    }
}
