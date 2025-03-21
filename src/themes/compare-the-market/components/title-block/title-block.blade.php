@props([
    'subtitle',
    'title',
])

<section
  {{ $attributes->class(['component component-title-block mb-16 mb-lg-16']) }} data-autoload-component="TitleBlock">

  @if ($title)
    <{{ $title_type }} class="h2 mb-8 mb-lg-24 fw-bold">
    {!! $title !!}
</{{ $title_type }} >
@endif
@if ($subtitle)
  <{{ $subtitle_type }} class="h3 mb-16 {{ $color ?: 'text-blue-600' }}">
  {!! $subtitle !!}
  </{{ $subtitle_type }}>
@endif
@if ($content || $slot)
  <div class="mb-16 {{ $color ?: 'text-greyscale-400' }} position-relative z-1">
    {!! $content ?: $slot !!}
  </div>
  @endif
</section>
