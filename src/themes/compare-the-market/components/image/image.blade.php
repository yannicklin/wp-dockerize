@if(!empty($image))
  <section class="component component-image">
    <picture class="{{ $attributes->get('class') }}">
      @if($alternate_images)
        @if($mobile_image)
          <source media="(max-width: 767px)" srcset="{{ $mobile_image['url'] }}" width="{{ $mobile_image['width'] }}" height="{{ $mobile_image['height'] }}">
        @endif
        @if($tablet_image)
          <source media="(max-width: 991px)" srcset="{{ $tablet_image['url'] }}" width="{{ $tablet_image['width'] }}" height="{{ $tablet_image['height'] }}">
        @endif
      @endif
      <img src="{{ $image['url'] ?: 'https://via.placeholder.com/1920' }}" @if($width)width="{{ $width }}"@endif @if($height)height="{{ $height }}"@endif alt="{{ $image['alt'] ?? $alt }}" loading="{{$lazy ? 'lazy' : 'eager'}}" @if(isset($image['id'])) srcset="{{ wp_get_attachment_image_srcset($image['id'])}}" sizes="{{ wp_get_attachment_image_sizes($image['id'], 'medium_large') }}"@endif decoding="async">
    </picture>
  </section>
@endif