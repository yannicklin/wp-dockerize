@if($buttons)
  <section {{ $attributes->class(['component component-button-group']) }} data-autoload-component="ButtonGroup">
    @foreach($buttons ?: [] as $button)
        <x-button :acf="$button['button']" class=""/>
    @endforeach
  </section>
@endif
