<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left text-nowrap"></x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Заголовок</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Действие</x-tt::table.heading>
            <x-tt::table.heading class="text-left text-nowrap">Фон кнопки</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($buttons as $item)
            <tr>
                <td>
                    <div class="flex justify-start">
                        @can("update", $block)
                            <button type="button" class="btn btn-sm btn-primary px-btn-x-ico rounded-e-none"
                                    @if ($loop->last) disabled @else wire:loading.attr="disabled" @endif
                                    wire:click="moveDown({{ $item->id }})">
                                <x-tt::ico.line-arrow-bottom width="18" height="18" />
                            </button>
                            <button type="button" class="btn btn-sm btn-primary px-btn-x-ico rounded-s-none"
                                    @if ($loop->first) disabled @else wire:loading.attr="disabled" @endif
                                    wire:click="moveUp({{ $item->id }})">
                                <x-tt::ico.line-arrow-top width="18" height="18" />
                            </button>
                        @endcan
                    </div>
                </td>
                <td>{{ $item->title }}</td>
                <td>
                    @if ($item->link)
                        <a href="{{ $item->link }}" target="_blank"
                           class="text-primary hover:text-primary-hover">
                            {{ $item->link }}
                        </a>
                    @elseif ($item->event)
                        Вызов формы "{{ ! empty($formList[$item->event]) ? $formList[$item->event] : "Неизвестно" }}"
                    @endif
                </td>
                <td>{{ $item->is_outline ? "Нет" : "Есть" }}</td>
                <td>
                    <div class="flex justify-center">
                        <button type="button" class="btn btn-sm btn-dark px-btn-x-ico rounded-e-none"
                                @cannot("update", $block) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showEdit({{ $item->id }})">
                            <x-tt::ico.edit/>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger px-btn-x-ico rounded-s-none"
                                @cannot("update", $block) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash/>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
