<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-best-price-promise-banner" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
  <div class="container">
    <x-banner-card class="py-lg-32 px-lg-48" :background="$card_colour" :type="$card_style">
      <div class="d-flex {{ isset($image_orientation) && $image_orientation == 'right' ? 'flex-column flex-lg-row' : 'flex-column-reverse flex-lg-row-reverse' }} align-items-center gap-32 gap-lg-64">
        <div class="d-flex flex-column flex-grow-1 gap-16">
          <{{$title_type ?? 'h2'}} class="{{$heading_size}} fw-800">{{$primary_heading}}</{{$title_type ?? 'h2'}}>
          <div class="body-m">{!! $description !!}</div>
          <x-button-group :acf="$button_group ?? []" class="d-inline-flex flex-wrap flex-row flex-column flex-md-row gap-8 gap-lg-16 w-100" />
          @if(isset($disclaimer) && !empty($disclaimer))
            <div class="body-xs {{ in_array($card_colour, ['blue-400','blue-500']) ? 'text-white' : 'text-greyscale-400' }}">{!! $disclaimer !!}</div>
          @endif
        </div>

        @if($sized_image)
          @php($arrImage = Array("image" => Array("url" => $sized_image, "alt" => $image['alt']), "alternate_images" => $mobile_behaviour, "tablet_image" => Array("url" => $image['sizes']['medium_large'], "width" => $image['sizes']['medium_large-width'], "height" => $image['sizes']['medium_large-height'] )))

          <div class="flex-shrink-0">
            <x-image :image="$arrImage" :width="$image_size" :height="$image_size" class="card-banner-image radius-s d-block overflow-hidden image-size-{{ $mobile_behaviour == true ? 'full' : 'auto' }}" />
          </div>
        @endif

      </div>
    </x-banner-card>
  </div>
</x-block-theme>