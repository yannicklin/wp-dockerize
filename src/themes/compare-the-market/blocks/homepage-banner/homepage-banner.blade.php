<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-homepage-banner position-relative" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">

  @if(!empty($block_style['image']['image']))
    <x-image :image="$block_style['image']" :width="$block_style['image']['image']['width']" :height="$block_style['image']['image']['height']" class="media position-absolute top-0 left-0 w-100 h-100" />
  @endif

  <div class="pt-40 {{ isset($desktop_top_padding) && $desktop_top_padding == '80' ? 'pt-lg-80' : '' }} pb-80 position-relative">
    <div class="container">
      <div class="row flex-column flex-lg-row text-center text-md-start">
        <div class="col-lg-7 mb-16 mb-lg-80">
          <div class="d-flex flex-column align-items-stretch align-items-lg-start gap-32 gap-lg-40">
            <div>
              <h1 class="mb-0">
                {!! $primary_heading !!}
              </h1>
              @if($subtitle)
                @php($subtitle_type = !empty($subtitle_type) ? $subtitle_type : 'h2')
                <{!! $subtitle_type !!} class="body-xxl mt-16 mb-0">{!! $subtitle !!}</{!! $subtitle_type !!}>
              @endif
            </div>

            @exists($button_group)
            <div class="row button-group">
              <div class="col col-12">
                <x-button-group :acf="$button_group ?? []" class="d-inline-flex flex-column flex-md-row gap-8 gap-lg-16 w-100"/>
              </div>
            </div>
            @endexists

            @isset($trust_widget)
              <x-trust-widget :acf="$trust_widget"/>
            @endisset
          </div>
        </div>
        <div class="col-lg-5 align-self-end">
          <div class="featured-image-container" style="
            --desktop-ratio:{{(($featured_image['image']['image']['height'] ?? 1) / ($featured_image['image']['image']['width'] ?? 1)) * 100}}%;
          @if($featured_image['image']['tablet_image'])
            --tablet-ratio:{{($featured_image['image']['tablet_image']['height'] / $featured_image['image']['tablet_image']['width']) * 100}}%;
          @endif
          @if($featured_image['image']['mobile_image'])
            --mobile-ratio:{{($featured_image['image']['mobile_image']['height'] / $featured_image['image']['mobile_image']['width']) * 100}}%
          @endif
            "
          >
            <x-image :image="$featured_image['image']" :width="$featured_image['image']['image']['width']" :height="$featured_image['image']['image']['height']" :lazy="false" class="media media-full" />
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="homepage-banner-scroll d-flex d-lg-none align-items-center justify-content-center position-fixed bottom-0 w-100 gap-5 p-10">
    Scroll  <x-icon icon="chevron" style="scale:-1"/>
  </div>
</x-block-theme>
