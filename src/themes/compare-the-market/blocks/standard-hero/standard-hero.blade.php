<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-standard-hero" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">

  <div class="pt-8 pb-24 {{ isset($desktop_top_padding) && $desktop_top_padding == '80' ? 'pt-lg-80' : 'pt-lg-40' }} pb-lg-80 position-relative">
    <div class="container">
      <div class="row pb-32 pb-lg-24">
        <div class="col-md-12">
          @if (!$hidebreadcrumbs)
            @if(function_exists('yoast_breadcrumb'))
              {!! yoast_breadcrumb('<p id="breadcrumbs" class="mb-0 body-s">','</p>') !!}
            @endif
          @endif
        </div>
      </div>
      <div class="row flex-column-reverse text-center {{ $hero_style == 'default' ? 'justify-content-between flex-lg-row text-lg-start' : 'justify-content-center flex-lg-column' }} align-items-center g-32 g-lg-0">
        <div class="col-lg-7 mb-16 mb-lg-0 py-lg-24">
          <div class="d-flex content-width flex-column align-items-md-center {{ $hero_style == 'default' ? 'align-items-lg-start pe-lg-32' : 'pb-lg-16' }} gap-32 gap-lg-40">
            <div>
              @if($heading_style == 'default')
                <h1 class="mb-0 fw-800">{!! $primary_heading !!}</h1>
                @if($subtitle)
                  @php($subtitle_type = !empty($subtitle_type) ? $subtitle_type : 'p')
                  <{!! $subtitle_type !!} class="body-xxl mt-16 mb-0 {{ in_array($block_theme['background_colour'], ['theme-brand-gradient-1', 'theme-blue', 'theme-dark-blue']) ? '' : 'text-blue-600' }}">{!! $subtitle !!}</{!! $subtitle_type !!}>
                @endif
              @else
                <p class="h1 mb-0 fw-800">{!! $primary_heading !!}</p>
                @if($subtitle)
                  <h1 class="body-xxl mt-16 mb-0 {{ in_array($block_theme['background_colour'], ['theme-brand-gradient-1', 'theme-blue', 'theme-dark-blue']) ? '' : 'text-blue-600' }}">{!! $subtitle !!}</h1>
                @endif
              @endif
              @if($description)
                <div class="body-m mt-lg-24 mb-0 {{ !in_array($block_theme['background_colour'], ['theme-brand-gradient-1', 'theme-blue', 'theme-dark-blue']) ? 'text-blue-600' : '' }}">{!! $description !!}</div>
              @endif
            </div>

            @if(isset($customize_buttons) && $customize_buttons)
              @if($button_type == 'button')
                @exists($button_group)
                  <div class="row button-group">
                    <div class="col col-12">
                      <x-button-group :acf="$button_group ?? []" class="d-inline-flex flex-column flex-md-row gap-8 gap-lg-16 w-100"/>
                    </div>
                  </div>
                @endexists
              @else
                <div class="row">
                  <div class="col col-12 d-inline-flex flex-column flex-md-row gap-8 gap-lg-16 w-100">
                    @foreach($image_buttons as $image_button)
                      <a href="{{ isset($image_button['link']) ? $image_button['link']['url'] : '#' }}">
                        <x-image :image="$image_button['image']['url']" :width="$image_button['image']['width']" :height="$image_button['image']['height']" :lazy="false" />
                      </a>
                    @endforeach
                  </div>
                </div>
              @endif
            @else
              @exists($vertical_cta_buttons)
                <div class="row button-group">
                  <div class="col col-12">
                    <x-button-group :acf="$vertical_cta_buttons ?? []" class="d-inline-flex flex-column flex-md-row gap-8 gap-lg-16 w-100"/>
                  </div>
                </div>
              @endexists
            @endif


            @isset($trust_widget)
            <x-trust-widget :acf="$trust_widget"/>
          @endisset
          </div>
        </div>
        @if (isset($featured_image['image']['image']))
          <div class="{{ $hero_style == 'default' 
          ? ($image_type == 'landscape' ? 'col-12 col-lg-5' : 'col-12 col-lg-5 col-xl-4 custom-image-square') 
          : ($image_type == 'landscape' ? 'col-12' : 'col-12 col-lg-8') }}">
            @if($imagelink)
            <a href="{{ $imagelink }}">
            @endif
            <div class="featured-image-container" style="
              --desktop-ratio:{{$desktop_ratio}}%;
              @if($tablet_ratio)
                --tablet-ratio:{{$tablet_ratio}}%;
              @endif
              @if($mobile_ratio)
                --mobile-ratio:{{$mobile_ratio}}%;
              @endif">
              <x-image :image="$featured_image['image']" :width="$featured_image['image']['image']['width']" :height="$featured_image['image']['image']['height']" :lazy="false" class="media media-full radius-lg-l radius-s" />
            </div>
          </div>
          @if($imagelink)
          </a>
          @endif
        @endif

      </div>
    </div>
  </div>

</x-block-theme>