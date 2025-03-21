<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name"
               class="block block-cards position-relative overflow-hidden" data-autoload-block="{{ $block_class }}"
               id="{{ $block_object->getBlockHtmlId() }}">

  @if($branded_curve == 'top' || $branded_curve == 'bottom')

    <div class="branded-curve position-absolute {{$branded_curve}}-0 text-{{$branded_curve_colour}}">

      <svg width="1920" height="360" viewBox="0 0 1920 360" fill="none" xmlns="http://www.w3.org/2000/svg"
           preserveAspectRatio="none" style="min-width: 100%;">
        <g clip-path="url(#clip0_1152_6802)">
          <path
            d="M1920 69.3211C1920 131.239 1920 118.576 1920 166.913C1710.32 244.853 1357.87 296 958.447 296C560.588 296 209.973 245.254 0.000525809 167.83C0.00346565 138.642 0.631471 124.048 0.000110269 62.0242C0.000110269 62.0242 -0.000302791 47.4303 0.000536169 0.000174045C210.045 8.48972e-05 560.985 -9.80857e-05 958.447 -0.00016758C1357.87 -0.000237418 1710.32 -0.000229712 1920 -0.000213855C1920 41.9575 1920 69.3211 1920 69.3211Z"
            fill="currentColor"/>
        </g>
        <defs>
          <clipPath id="clip0_1152_6802">
            <rect width="1920" height="360" fill="white"/>
          </clipPath>
        </defs>
      </svg>

    </div>
  @endif


  <div class="container position-relative cards-container">
    <div class="section-heading mb-40 mb-lg-64 text-center">
      <{{ $title_type ?? 'h2' }} class="h2 mb-8 {{ $is_heading_white ? 'text-white' : 'text-blue-500' }}">{!! $primary_heading !!}</{{ $title_type ?? 'h2' }}>
      <div class="{{ $is_heading_white ? 'text-white' : 'text-blue-600' }}">
      {!! $description !!}
      </div>
    </div>

    @if($mobile_layout == 'slider')
      <div class="swiper overflow-visible">
        <div class="row g-32 g-lg-40 justify-content-lg-center swiper-wrapper flex-nowrap flex-lg-wrap">
          @foreach($cards as $index => $card)
            <div class="col-lg-4 swiper-slide">
              @include('Blocks::cards.card', ['card' => $card, 'icon_type' => $icon_type, 'title_type' => ($card_title_type ?? 'h3'), 'index' => ($index + 1)])
            </div>
          @endforeach
        </div>
      </div>
    @else
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-40 justify-content-center">
        @foreach($cards as $index => $card)
          <div class="col">
            @include('Blocks::cards.card', ['card' => $card, 'icon_type' => $icon_type, 'title_type' => ($card_title_type ?? 'h3'), 'index' => ($index + 1)])
          </div>
        @endforeach
      </div>
    @endif
  </div>

</x-block-theme>
