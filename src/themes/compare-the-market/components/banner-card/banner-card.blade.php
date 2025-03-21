@props([
    'type',
    'background',
])
<section {{ $attributes->class($classes()) }} >
  {!! $slot !!}
</section>
