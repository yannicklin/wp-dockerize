<section
  {{ $attributes->class([$theme['background_colour'] ?? '', $classes_paddings, $classes_margins]) }}
  {{ $attributes->except(['class']) }}
  data-autoload-component="BlockTheme"
  data-component-type="{{ $name }}"
  {{$attributes}}
>
  {!! $slot !!}
</section>