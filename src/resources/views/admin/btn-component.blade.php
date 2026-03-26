@props(["blockItem"])
<livewire:ebtns-btn-list :$blockItem wire:key="{{ $blockItem->id }}--{{ $blockItem->recordable->id }}" />
