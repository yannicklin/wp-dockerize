@php use Atlas\Components\Link; @endphp
@if($type === Link::TYPE_LINK)
  <a href="{{ $link['url'] ?? '#' }}" target="{{ $link['target'] ?? '' }}" {{ $attributes->class([]) }} aria-label="Link to {{ $title }}">
    @if($slot && $slot->isNotEmpty())
      {{ $slot }}
    @elseif($title)
      {!! $title !!}
    @endif
  </a>
@elseif($type === Link::TYPE_FILE)
  <a href="{{ $file['url'] ?? '#' }}" target="_blank" {{ $attributes->class([]) }}  aria-label="Link to {{ $title }}">
    @if($slot)
      {{ $slot }}
    @elseif($title)
      {!! $title !!}
    @endif
  </a>
@endif
