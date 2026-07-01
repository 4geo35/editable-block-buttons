@props(["blockItem"])
<livewire:ebtns-btn-list :$blockItem wire:key="item-{{ $blockItem->modelHash }}{{ $blockItem->id }}" />
