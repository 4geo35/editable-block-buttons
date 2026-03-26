<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить кнопку</x-slot>
    <x-slot name="text">Будет невозможно восстановить кнопку!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">{{ $btnId ? "Редактировать" : "Добавить" }} кнопку</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $btnId ? 'update' : 'store' }}" class="space-y-indent-half"
              id="blockButtonsDataForm-{{ $blockItem->id }}">

            <div>
                <label for="blockButtonsTitle-{{ $blockItem->id }}" class="inline-block mb-2">
                    Заголовок<span class="text-danger">*</span>
                </label>
                <input type="text" id="blockButtonsTitle-{{ $blockItem->id }}"
                       class="form-control {{ $errors->has("title") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="title">
                <x-tt::form.error name="title"/>
            </div>

            <div>
                <label for="blockButtonsLink-{{ $blockItem->id }}" class="inline-block mb-2">
                    Ссылка
                </label>
                <input type="text" id="blockButtonsLink-{{ $blockItem->id }}"
                       class="form-control {{ $errors->has("link") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="link">
                <x-tt::form.error name="link"/>
            </div>

            @if (count($formList))
                <div>
                    <div class="inline-block mb-2">Вызов формы</div>
                    <select class="form-select {{ $errors->has('event') ? 'border-danger' : '' }}"
                            wire:model="event">
                        <option value="">Выберите...</option>
                        @foreach($formList as $formKey => $formTitle)
                            <option value="{{ $formKey }}">{{ $formTitle }}</option>
                        @endforeach
                    </select>
                    <x-tt::form.error name="event"/>
                </div>

            @endif

            <div class="form-check">
                <input type="checkbox" wire:model="isOutline" id="blockButtonsIsOutline-{{ $blockItem->id }}"
                       class="form-check-input {{ $errors->has('isOutline') ? 'border-danger' : '' }}"/>
                <label for="blockButtonsIsOutline-{{ $blockItem->id }}" class="form-check-label">
                    Кнопка без фона
                </label>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="blockButtonsDataForm-{{ $blockItem->id }}" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $btnId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
