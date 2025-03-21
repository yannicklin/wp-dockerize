<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-content-carousel" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">

  @exists(collect($title_block)->only(['title', 'subtitle', 'content']))
    <div class="container mb-64">
      <div class="row">
        <div class="col col-12">
          <x-title-block-headless class="text-center">
            <x-slot name="title">
              @if($title = $title_block['title'])
                @php($title_type = $title_block['title_type'] ?? 'h2')
                <{{ $title_type }} class="h2 fw-800 mb-8 {{ in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? 'text-white' : 'text-blue-500' }}">
                {{ $title_block['title'] }}
            </{{ $title_type }} >
            @endif
            </x-slot>
            <x-slot name="subtitle">
              @if($subtitle = $title_block['subtitle'])
                @php($title_type = $title_block['subtitle_type'] ?? 'h2')
                <{{ $title_type }} class="h3 {{ in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? 'text-white' : 'text-blue-600' }} mb-16">
                {{ $title_block['subtitle'] }}
            </{{ $title_type }}>
            @endif
            </x-slot>
            <x-slot name="content">
              @if($content = $title_block['content'])
                <div class="{{ in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? 'text-white' : 'text-blue-600' }} body-l mb-0">{!! $content  !!}</div>
              @endif
            </x-slot>
          </x-title-block-headless>
        </div>
      </div>
    </div>
  @endexists
  <div class="container">
    <div class="row position-relative">
      <div class="swiper-container position-relative overflow-x-hidden" data-slides="{{ $columns }}" style="width: 100%;">
        <div class="swiper-wrapper">
          @foreach($carousel_items ?: [] as $carousel_item)
            <div class="swiper-slide d-flex">
              @if($card_style === 'none')
                <div>
                  @include('Blocks::content-carousel.content')
                </div>
              @else
                <x-banner-card class="p-24 p-lg-32" :background="$card_colour" :type="$card_style">
                  @include('Blocks::content-carousel.content')
                </x-banner-card>
              @endif
            </div>
          @endforeach

        </div>
      </div>
      <div
        class="swiper-pagination text-start"
        style="
          max-width: 75%;
          --swiper-pagination-bottom: 0px;
          --swiper-pagination-bullet-width: 50px;
          --swiper-pagination-bullet-horizontal-gap: 2px;
          --swiper-pagination-bullet-inactive-color: #B4D4F8;
          --swiper-pagination-color: #0F58AB;
        "></div>
      <div class="swiper-buttons" style="--swiper-navigation-size: 24px;--swiper-navigation-sides-offset: -4px;">
        <div class="swiper-button-prev width-48 height-48 radius-round text-blue-500">
          <i class="fa-regular fa-chevron-left"></i>
        </div>
        <div class="swiper-button-next width-48 height-48 radius-round text-blue-500">
          <i class="fa-regular fa-chevron-right"></i>
        </div>
      </div>
    </div>
  </div>
</x-block-theme>
