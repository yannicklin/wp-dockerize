<x-block-theme
  :acf="$block_theme ?? []"
  :name="$block_object->name"
  class="block block-video-reel"
  data-autoload-block="{{ $block_class }}"
  data-slider-timing="{{ ($slider_timing ?? 3) * 1000 }}"
  id="{{ $block_object->getBlockHtmlId() }}" data-modal-id="{{ $modalId }}">
  <div class="container">
    <div class="row mb-16 position-relative">
      @exists(collect($title_block)->only(['title', 'subtitle', 'content']))

      <div class="col col-12 text-center mb-80">
        <x-title-block
          :acf="$title_block ?? []"
          :color="in_array($block_theme['background_colour'], ['theme-blue', 'theme-dark-blue', 'theme-blue']) ? 'text-white' : ''"
        />
      </div>
      @endexists
      <div class="swiper-container" style="height: auto !important;">
        <div class="swiper-wrapper">
          @foreach($video_reels as $reel_index => $reel)
            <div class="swiper-slide d-flex">
              <div class="col-md-12 d-flex flex-column">
                <div
                  class="flex-grow-1 border border-blue-300 border-1.5 {{ ($show_transcript ?? false) ? 'border-bottom-0 border-bottom-radius-0' : '' }} radius-s d-flex flex-column flex-lg-row overflow-hidden">
                  <!-- left -->
                  <div
                    class="w-100 order-1 order-lg-0 w-lg-50 pt-40 px-32 pb-32 bg-white d-flex flex-column justify-content-between flex-grow-1 video-reel-content">

                    <div>
                      @if(count($video_reels) > 1)
                      <div class="justify-content-start align-items-start flex-column d-lg-none d-flex">
                        <div class="swiper-internal-pagination d-flex mb-32">
                          @foreach($video_reels as $k => $reel_content)
                            <button data-reel-target="{{ $k }}"
                                    class="me-4 width-32 height-4 border-0 {{ $reel_index === $k ? 'active bg-blue-400' : 'inactive bg-blue-300'}}"
                                    style="border-radius: 2px;"></button>
                          @endforeach
                        </div>
                        <div class="swiper-internal-navigation mb-24 d-flex">
                          <button
                            class="swiper-internal-navigation-prev d-flex justify-content-center align-items-center radius-round width-32 height-32 border-0 bg-white me-8">
                            <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M0.417866 7.4495L7.35421 0.549286C7.67935 0.188018 8.22125 0.188018 8.58252 0.549286C8.90766 0.874427 8.90766 1.41633 8.58252 1.74147L2.22421 8.06366L8.54639 14.422C8.90766 14.7471 8.90766 15.289 8.54639 15.6142C8.22125 15.9754 7.67935 15.9754 7.35421 15.6142L0.417866 8.67781C0.0565981 8.35267 0.0565981 7.81077 0.417866 7.4495Z"
                                fill="#001464"/>
                            </svg>
                          </button>
                          <button
                            class="swiper-internal-navigation-next d-flex justify-content-center align-items-center radius-round width-32 height-32 border-0 bg-white">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path
                                d="M17.2384 11.4495C17.5635 11.8108 17.5635 12.3527 17.2384 12.6778L10.302 19.6142C9.94077 19.9754 9.39887 19.9754 9.07373 19.6142C8.71246 19.289 8.71246 18.7471 9.07373 18.422L15.3959 12.0998L9.07373 5.74147C8.71246 5.41633 8.71246 4.87443 9.07373 4.54929C9.39887 4.18802 9.94077 4.18802 10.2659 4.54929L17.2384 11.4495Z"
                                fill="#001464"/>
                            </svg>
                          </button>
                        </div>
                      </div>
                      @endif

                      @if($subtitle = $reel['subtitle'] ?? false)
                        @php($subtitle_type = $reel['subtitle_type'] ?? 'h3')
                        <{{ $subtitle_type }} class="p body-m mb-8  text-blue-500">{{ $subtitle }}</{{ $subtitle_type }}
                    >
                    @endif
                    @if($heading2 = $reel['heading_2'] ?? false)
                      @php($heading_2_type = $reel['heading_2_type'] ?? 'h2')
                      <{{ $heading_2_type }} class="h2 mb-8 text-blue-500">{{ $heading2 }}</{{ $heading_2_type }}>
                  @endif
                  @if($heading3 = $reel['heading_3'] ?? false)
                    @php($heading_3_type = $reel['heading_3_type'] ?? 'h3')
                    <{{ $heading_3_type }} class="h3 mb-16 text-blue-500">{{ $heading3 }}</{{ $heading_3_type }}>
                @endif
                @if($description = $reel['description'] ?? false)
                  <div class="body-m mb-24 text-blue-600">
                    {!! $description !!}
                  </div>
                @endif

                @if($reel['button']['link']['title'] || $reel['button']['link']['link'])
                  @if($button = $reel['button'] ?? false)
                    <x-button :acf="$button"/>
                  @endif
                @endif
              </div>

              <div>
                @if($author = $reel['expert_label'] ?? false)
                  <div class="w-100">
                    <x-expert-label :acf="$author" :background="'bg-white'" class="mt-32 ps-0 {{ count($video_reels) > 1 ? 'mb-32 pb-0' : '' }}"/>
                  </div>
                @endif
                @if(count($video_reels) > 1)
                  <div class="justify-content-between align-items-center d-none d-lg-flex">
                    <div class="swiper-internal-pagination d-flex">
                      @foreach($video_reels as $k => $reel_content)
                        <button data-reel-target="{{ $k }}"
                                class="me-4 width-32 height-4 border-0 {{ $reel_index === $k ? 'active bg-blue-400' : 'inactive bg-blue-300'}}"
                                style="border-radius: 2px;"></button>
                      @endforeach
                    </div>
                    @if(count($video_reels) > 1)
                      <div class="swiper-internal-navigation">
                        <button
                          class="swiper-internal-navigation-prev  radius-round width-48 height-48 border-0 bg-white me-8">
                          <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M0.417866 7.4495L7.35421 0.549286C7.67935 0.188018 8.22125 0.188018 8.58252 0.549286C8.90766 0.874427 8.90766 1.41633 8.58252 1.74147L2.22421 8.06366L8.54639 14.422C8.90766 14.7471 8.90766 15.289 8.54639 15.6142C8.22125 15.9754 7.67935 15.9754 7.35421 15.6142L0.417866 8.67781C0.0565981 8.35267 0.0565981 7.81077 0.417866 7.4495Z"
                              fill="#001464"/>
                          </svg>
                        </button>
                        <button
                          class="swiper-internal-navigation-next radius-round width-48 height-48 border-0 bg-white">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M17.2384 11.4495C17.5635 11.8108 17.5635 12.3527 17.2384 12.6778L10.302 19.6142C9.94077 19.9754 9.39887 19.9754 9.07373 19.6142C8.71246 19.289 8.71246 18.7471 9.07373 18.422L15.3959 12.0998L9.07373 5.74147C8.71246 5.41633 8.71246 4.87443 9.07373 4.54929C9.39887 4.18802 9.94077 4.18802 10.2659 4.54929L17.2384 11.4495Z"
                              fill="#001464"/>
                          </svg>
                        </button>
                      </div>
                    @endif
                  </div>
                @endif
              </div>
            </div>
            <!-- right -->
            <div class="w-100 order-0 order-lg-1 w-lg-50 d-flex video-reel-thumbnail position-relative">
              <div class="position-absolute bottom-0 w-100 video-reel-thumbnail-description">
                <button data-modal-target="{{ $modalId }}" data-modal-index="{{ $reel_index }}"
                        title="Play video - {{ $heading2 ?? '' }}"
                        class="mx-24 mx-lg-32 video-reel-play-button d-flex justify-content-center align-items-center border border-2 border-white radius-round width-56 height-56 ">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M8.84754 4.72811L18.8972 10.8696C19.3857 11.1836 19.6998 11.7419 19.6998 12.3002C19.6998 12.8934 19.3857 13.4518 18.8972 13.7309L8.84754 19.8724C8.32412 20.1864 7.66113 20.2213 7.13771 19.9073C6.61429 19.6281 6.30024 19.0698 6.30024 18.4417V6.15879C6.30024 5.56558 6.61429 5.00727 7.13771 4.72811C7.66113 4.41406 8.32412 4.41406 8.84754 4.72811Z"
                      fill="#001464"/>
                  </svg>
                </button>
                <div class="pb-24 px-24 pb-lg-32 px-lg-32 mt-16 ">
                  @if($video_title = $reel['video_title'] ?? false)
                    @php($video_title_type = $reel['video_title_type'] ?? 'p')
                    <{{ $video_title_type }} class="body-xxl text-white mb-0 fw-700">
                    {{ $video_title }}
                </{{ $video_title_type }}>
                @endif
                @if($video_description = $reel['video_description'] ?? false)
                  @php($video_description_type = $reel['video_description_type'] ?? 'p')
                  <{{ $video_description_type }} class="body-m text-white">
                  {{ $video_description }}
              </{{ $video_description_type }}>
              @endif
            </div>
        </div>
        @if($thumbnail = $reel['image'] ?? false)
          <x-image :image="$thumbnail" :width="$thumbnail['image']['width']" :height="$thumbnail['image']['height']" />
        @endif
      </div>
    </div>
    @if($show_transcript ?? false)
      <div class="w-100">
        <!-- transcript -->
        <x-ctm-accordion class="border-top-radius-0" :block="$block_object" :id="uniqid()" showTitle="Transcript" hideTitle="Transcript">
          <div class="py-32 px-24 text-greyscale-400 bg-white">
            @if($transcript = $reel['transcript'] ?? false)
              {!! $transcript !!}
            @endif
          </div>
        </x-ctm-accordion>
      </div>
    @endif
  </div>
  </div>
  @endforeach
  </div>
  </div>
  </div>
  </div>
  @push('footer:scripts')
    <x-modal id="{{ $modalId }}" class="overflow-hidden">
      <x-slot name="body">
        <div class="swiper swiper-container modal-reel">
          <div class="swiper-wrapper">
            @foreach($video_reels as $reel)
              <div class="swiper-slide">
                @if($wistia_id = $reel['wistia_id'] ?? false)
                  <script src="//fast.wistia.com/embed/medias/{{ $wistia_id }}.jsonp" async></script>
                  <div style="height: 640px; width: 100%;" class="w-100 wistia_embed wistia_async_{{ $wistia_id }} playerColor=666666">&nbsp;</div>
                @endif
              </div>
            @endforeach
          </div>
        </div>
        <div class="swiper swiper-container modal-thumbnails mt-56" style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff; --swiper-navigation-size: 12px;">
          <div class="swiper-wrapper justify-content-center">
            @foreach($video_reels as $reel)
              <div class="swiper-slide">
                @if($thumbnail = $reel['image'] ?? false)
                  <x-image :image="$thumbnail" :width="$thumbnail['image']['sizes']['image_size_small-width']" :height="$thumbnail['image']['sizes']['image_size_small-height']" class="media media-full" />
                @endif
              </div>
            @endforeach
          </div>
          @if(count($video_reels) > 1)
          <div class="swiper-navigation">
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
          @endif
        </div>
      </x-slot>
    </x-modal>
  @endpush
</x-block-theme>
