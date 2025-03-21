<div class="d-flex {{ $layout === 'stacked' ? 'flex-column' : 'flex-column flex-lg-row' }}">
  <div class="image-container radius-s overflow-hidden h-100 {{ $layout === 'inline' && !$flip ? 'me-lg-24' : '' }} {{ $flip ? 'order-lg-1' : '' }} {{ match($image_width) {
    '25%' => 'w-25',
    '50%' => 'w-50',
    '75%' => 'w-75',
    default => 'w-100'
  } }}">
    @if(!empty($carousel_item['image']))
      @php
        $image_dimension_height = (int)$image_height ?: $carousel_item['image']['image']['height'];
        $image_dimension_width = $carousel_item['image']['image']['width'] / $carousel_item['image']['image']['height'] * $image_dimension_height;
      @endphp
      <x-image :image="$carousel_item['image']" :width="$image_dimension_width" :height="$image_dimension_height" />
    @else
      <x-image :image="[]" />
    @endif
  </div>
  <div class="content-container {{ $layout === 'stacked' && $flip  ? 'mb-24' : 'mb-24 mb-lg-0' }}  {{ match($image_width) {
    '25%' => 'w-75',
    '50%' => 'w-50',
    '75%' => 'w-25',
    default => 'w-100'
  } }} {{ $flip && $layout === 'inline' ? 'ms-24' : '' }}">
    @if($heading = $carousel_item['heading'])
      <h4 class="fw-800 mb-24 {{ ($layout === 'stacked' && !$flip) ? 'mt-24' : 'mt-24 mt-lg-0' }}">
        {{ $heading }}
      </h4>
    @endif
    @if($description = $carousel_item['description'])
      <p class="{{ $layout === 'stacked' ? 'mb-32' : 'mb-24' }}">{{ $description }}</p>
    @endif
    @if($button = $carousel_item['button'])
      @if(isset($button['link']['title']) && $button['link']['title'])
        <x-button :acf="$button"/>
      @endisset
    @endif
  </div>
</div>
