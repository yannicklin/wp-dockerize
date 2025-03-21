<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-cta-banner position-relative {{ $block_contained ? 'contained' : ''}}" style="{{$inline_margin_style}}" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">

  <div class="{{ $block_contained ? 'container' : ''}}">
    <div class="position-relative  {{ $block_contained ? 'radius-s overflow-hidden' : '' }}">

      @if($block_background_choice == 'image' && !empty($block_background_image['image']))
        <x-image :image="$block_background_image['image']" :width="$block_background_image['image']['image']['width']" :height="$block_background_image['image']['image']['height']" class="media position-absolute top-0 left-0 w-100 h-100" />
      @endif
      @if($block_background_choice == 'colour' && ($block_theme['background_colour'] ?? []))
        <div class="{{$block_theme['background_colour']}} position-absolute top-0 left-0 w-100 h-100"></div>
      @endif

        <div class="position-relative {{ $block_contained ? 'px-20 px-lg-60 ' : 'container'}}">

          <div class="row {{ !empty($featured_image) ? 'justify-content-between' : 'justify-content-center'}}">

            <div class="col-12 {{$content_column}} align-self-{{$vertical_alignment}} text-{{$content_alignment}} py-40 py-lg-60 d-flex flex-column {{$content_gap ?? 'gap-16'}}">

              @if($title_type == 'image' && !empty($image_title['image']))
                @php($image_source = $image_title['image'])
                <x-image :image="$image_source" :width="$image_source['image']['width']" :height="$image_source['image']['height']" />
              @endif

              @if($title_type == 'text')
                @if($primary_title['title'])
                  <{{$primary_title['title_class']}} class="primary-title"
                  style="--title-font-size:{{$primary_title['title_size']}}px;--title-font-size-mobile:{{$primary_title['title_size_mobile']}}px;{{ $primary_title['override_colour'] ? 'color:' .  $primary_title['override_colour'] : '' }}">
                    {{$primary_title['title']}}
                  </{{$primary_title['title_class']}}>
                @endif

                @if($subtitle['title'])
                  <{{$subtitle['title_class']}}  class="subtitle"
                  style="--subtitle-font-size:{{$subtitle['title_size']}}px;--subtitle-font-size-mobile:{{$subtitle['title_size_mobile']}}px;{{ $subtitle['override_colour'] ? 'color:' .  $subtitle['override_colour'] : '' }}">
                    {{$subtitle['title']}}
                  </{{$subtitle['title_class']}}>
                @endif
              @endif

              @if($button_type == 'button')
                @exists($button_group)
                <div class="row button-group">
                  <div class="col col-12">
                    <x-button-group :acf="$button_group ?? []" class="d-inline-flex flex-row gap-10 justify-content-{{$content_alignment}}"/>
                  </div>
                </div>
                @endexists
              @else
                <div class="row mt-40">
                  <div class="col col-12 d-inline-flex flex-row gap-10 justify-content-{{$content_alignment}}">
                    @foreach($image_buttons as $image_button)
                      <a href="{{ isset($image_button['link']) ? $image_button['link']['url'] : '#' }}">
                        <x-image :image="$image_button['image']['url']" :width="$image_button['image']['width']" :height="$image_button['image']['height']" />
                      </a>
                    @endforeach
                  </div>
                </div>
              @endif
            </div>
            @if(!empty($featured_image) || !empty($feature_image['image']['image']))
              <div class="col-12 {{$media_column}} align-self-{{$media_vertical_alignment}}">
                <div class="row">
                  <div class="{{$image_width}} d-flex justify-content-center justify-content-lg-end">
                    @if($imagelink)
                    <a href="{{ $imagelink }}">
                    @endif
                    @if(!empty($feature_image['image']['image']))
                      <x-image :image="$feature_image['image']" :width="$feature_image['image']['image']['width']" :height="$feature_image['image']['image']['height']" />
                    @else
                      <x-image :image="$featured_image['url']" :width="$featured_image['width']" :height="$featured_image['height']" />
                    @endif
                    @if($imagelink)
                  </a>
                  @endif
                  </div>
                </div>
              </div>
            @endif
        </div>
      </div>
    </div>
  </div>

</x-block-theme>
