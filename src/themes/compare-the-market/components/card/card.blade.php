@props([
    'image',
    'body',
])
<section {{ $attributes->class(['card']) }}>
  <div class="card-header p-0">
    {{ $image }}
  </div>
  <div class="card-body">
    {{ $body }}
  </div>
  {!! $slot !!}
</section>
