<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-vertical-banner" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">

  <div class="pt-40 {{ isset($desktop_top_padding) && $desktop_top_padding == '80' ? 'pt-lg-80' : '' }} pb-80 position-relative">
    <div class="container">
      <div class="row flex-column flex-lg-row text-center gy-30 gy-lg-0 text-lg-start justify-content-between align-items-center {{(!empty($hero_design) && $hero_design === 'campaign') ? 'align-items-lg-end' : 'flex-column-reverse'}}">
        <div class="col-lg-7">

          <div class="d-flex flex-column align-items-center align-items-lg-start gap-24 gap-lg-48">

            <div>
              <h1 class="mb-0">
                {!! $primary_heading !!}
              </h1>
              @if($subtitle)
                @php($subtitle_type = !empty($subtitle_type) ? $subtitle_type : 'h2')
                <{!! $subtitle_type !!} class="body-xl mt-16 mb-0">{!! $subtitle !!}</{!! $subtitle_type !!}>
              @endif
            </div>

            @if(!empty($banner_cta_buttons['button']))
              <div class="button-group d-flex flex-column flex-lg-row flex-wrap align-items-center gap-24 w-100">
                <div class="col-12 col-md-auto">
                  <x-button :acf="$banner_cta_buttons['button']" class="w-100"/>
                </div>

                @if($banner_cta_buttons['display_phone_number'] && !empty($phone = $banner_cta_buttons['phone']))
                  <div class="col-auto">
                    <div class="fs-20 d-flex align-items-center justify-content-center radius-round fw-600" style="width:40px;height:40px;border: 1px solid rgba(255, 255, 255, 0.24);">
                      <div style="margin-top: -4px">or</div>
                    </div>
                  </div>
                  <div class="col-auto">
                    <div class="d-flex flex-column gap-8 align-items-center align-items-lg-start">
                      <div class="d-flex align-items-center gap-8 fs-20">
                        <x-icon icon="phone-inverted" class="fs-18"/>
                        <div class="fw-bold border-bottom"><a class="phone-link" href="tel:{{  str_replace(' ', '', $phone) }}">{{ $phone }}</a></div>
                      </div>

                      @if(!empty($banner_cta_buttons['display_opening_hours']))
                        {!! do_shortcode('[health_opening_hours id="opening-hours-' .  $block_object->getBlockHtmlId() . '" api="' . $opening_hours_api . '" class="body-xs" wrapper="div"]') !!}
                      @endif
                    </div>
                  </div>
                @endif
              </div>
            @endif
            @isset($trust_widget)
            <x-trust-widget :acf="$trust_widget"/>
            @endisset
          </div>
        </div>

        <div class="position-relative {{(!empty($hero_design) && $hero_design === 'campaign') ? 'col-12 col-md-8 col-lg-5 hero-design-campaign' : 'col-8 col-md-8 col-lg-4 hero-design-standard'}}">
          @if($imagelink)
          <a href="{{ $imagelink }}">
          @endif
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
          @if($imagelink)
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-block-theme>