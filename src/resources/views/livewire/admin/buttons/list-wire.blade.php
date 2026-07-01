<div class="{{ $useCardCover ? 'card' : 'mt-indent' }}">
    @if (!$useCardCover)
        <div class="border-t border-secondary"></div>
    @endif
    <div class="{{ $useCardCover ? 'card-header border-b-0' : 'card-body' }} space-y-indent-half">
        <div class="flex items-center justify-between">
            <div class="text-lg font-semibold mr-indent-half">Дополнительные кнопки</div>

            <button type="button" class="btn btn-outline-primary px-btn-x-ico lg:px-btn-x"
                    wire:loading.attr="disabled"
                    wire:click="showCreate">
                <x-tt::ico.circle-plus />
                <span class="hidden lg:inline-block pl-btn-ico-text">Добавить кнопку</span>
            </button>
        </div>
        <x-tt::notifications.error prefix="block-buttons-{{ $blockItem->id }}-" />
        <x-tt::notifications.success prefix="block-buttons-{{ $blockItem->id }}-" />
    </div>

    @include("ebtns::admin.includes.table")
    @include("ebtns::admin.includes.table-modals")
</div>
