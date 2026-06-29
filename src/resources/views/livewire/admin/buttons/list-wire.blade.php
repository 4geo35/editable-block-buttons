<div class="border-t border-stroke">
    <div class="card-body">
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
