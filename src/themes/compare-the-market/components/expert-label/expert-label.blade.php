@if($name)
<section {{ $attributes->class(['component component-expert-label d-inline-block p-8 pe-64 ' . $background]) }} data-autoload-component="ExpertLabel">
  <div class="d-flex gap-16">
    <div class="expert-image d-block position-relative w-auto">
      @if($image)
        <x-image :image="$image['sizes']['thumbnail']" :width="48" :height="48" :lazy="false" class="d-block radius-round overflow-hidden width-48 height-48" />
      @endif
    </div>
    <div>
      <div class="body-m text-blue-500 fw-bold expert-name">{{$name}}</div>
      <div class="body-s text-blue-600 expert-area">{{$area_of_expertise}}</div>
    </div>
  </div>
</section>
@endif
