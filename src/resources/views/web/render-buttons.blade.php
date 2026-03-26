@props(["blockItem"])
@if($blockItem->orderedButtons->count())
    <div class="mt-indent flex flex-wrap">
        @foreach($blockItem->orderedButtons as $button)
            @php($btnClass = $button->is_outline ? 'btn-outline-primary' : 'btn-primary')
            @if ($button->link)
                <a href="{{ $button->link }}" class="btn {{ $btnClass }} w-full xs:w-auto mb-indent-xs xs:mr-indent-half">
                    {{ $button->title }}
                </a>
            @elseif ($button->event)
                <button type="button"
                        x-data
                        @click.stop="$dispatch('show-request-form', { key: '{{ $button->event }}', place : 'Кнопка {{ htmlspecialchars($button->title) }} в Блоке {{ htmlspecialchars($blockItem->block->render_title ? $blockItem->block->render_title : $blockItem->block->title) }}, {{ htmlspecialchars($blockItem->title) }}'})"
                        class="btn {{ $btnClass }} w-full xs:w-auto mb-indent-xs xs:mr-indent-half">
                    {{ $button->title }}
                </button>
            @endif
        @endforeach
    </div>
@endif
