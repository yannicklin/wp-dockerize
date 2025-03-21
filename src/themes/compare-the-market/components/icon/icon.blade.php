@if($icon)
  <section {{ $attributes->class(['component component-icon']) }}>
    {!! file_get_contents($icon) !!}
  </section>
@endif
