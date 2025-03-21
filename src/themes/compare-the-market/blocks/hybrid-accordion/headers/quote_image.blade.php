<div class="col-md-12">
  @if($title)
    <{{ $title_type }} class="pt-24 pb-16 px-24 w-100 mb-0 text-blue-600">{{ $title }}</{{ $title_type }}>
  @endif
</div>
<div class="col-xl">
  <div class="py-32 px-24 pe-xl-8">
    @if($quote)
      <blockquote class="h4 text-blue-600 mb-0">
        {{ $quote }}
      </blockquote>
    @endif
    @if($author)
      <x-expert-label :acf="$author" class="mt-24"/>
    @endif
  </div>
</div>
<div class="{{ isset($image_width) ? 'col-xl-' . $image_width  : 'col-xl-5'  }}">
  <div class="py-32 pe-xl-24 ps-xl-0 px-24">
    @if($image)
      <div class="radius-s overflow-hidden w-100">
        <x-image :image="$image" :width="$image['image']['width']" :height="$image['image']['height']" />
      </div>
    @endif
  </div>
</div>
