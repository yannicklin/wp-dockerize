<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-standard-left-right"
               data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
  <div class="container">
    <div
      class="row {{ $media_orientation == "left" ? "flex-md-row-reverse" : ""}} align-items-center justify-content-between g-32">
      <div class="col-lg-5">
        <div class="content-container">
          <{{$title_type ?? 'h2'}} class="h2 mb-16">{!! $primary_heading !!}</{{$title_type ?? 'h2'}}>
          <div class="rte">
            {!! $description !!}
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="media-container position-relative d-flex flex-column-reverse align-items-center">
          @if($lottie_file)
            <dotlottie-player
              @if(isset($lottie_animation_width))
                style="
                --desktop-large-width:{{ $lottie_animation_width['desktop_large'] }}px;
                --desktop-width:{{ $lottie_animation_width['desktop'] }}px;
                @if($lottie_animation_width['tablet'] !== '0')--tablet-width:{{ $lottie_animation_width['tablet'] }}px;@endif
                @if($lottie_animation_width['mobile'] !== '0')--mobile-width:{{ $lottie_animation_width['mobile'] }}px;@endif
                "
              @endif
              autoplay
              loop
              background="transparent"
              src="{{ $lottie_file  }}"
            ></dotlottie-player>
          @endif
          <x-image :image="$featured_image['image']" :width="$featured_image['image']['image']['width']" :height="$featured_image['image']['image']['height']" class="radius-l overflow-hidden d-block"/>
        </div>
      </div>
    </div>
  </div>
</x-block-theme>