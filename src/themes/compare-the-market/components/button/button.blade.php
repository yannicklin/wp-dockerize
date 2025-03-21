<x-link :acf="$link" {{ $attributes->class($classes()) }}>
  @if($icon_position == 'left' && is_string($icon))
    <section class="component component-icon">
      {!! $icon !!}
    </section>
  @endif
  <span>{!! $link['title'] ?? '' !!}</span>
  @if($icon_position == 'right' && is_string($icon))
    <section class="component component-icon">
      {!! $icon !!}
    </section>
  @endif
</x-link>
