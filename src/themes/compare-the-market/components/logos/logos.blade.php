<section class="component component-logos" data-autoload-component="Logos" data-randomize="{{ $randomize ? '1' : '0' }}" data-view-less="{{ $viewLessMobile }}" data-view-all="{{ $viewAllMobile }}">
  @if(count($logos))
    <{!! !empty($wrapperOverride) ? sprintf('a href="%s"', $wrapperOverride) : 'div' !!}
      class="logos-container justify-content-center mb-40 g-16 row row-cols-3 {{ count($logos) > 7 ? 'row-cols-lg-7' : 'row-cols-lg-' . count($logos) }} {{ $headings ? 'mt-40' : '' }}" >
      @foreach($logos as $logo)
        @if(!$logo['logo'])
          @continue
        @endif
        <div class="col logo-container {{ $loop->index >= 9 ? 'd-none d-lg-block' : '' }}">
          <{!! (empty($wrapperOverride) && !empty($logo['url'])) ? sprintf('a href="%s"', $logo['url']) : 'div' !!} class="logo p-10 d-flex justify-content-center align-items-center radius-xs bg-greyscale-094">
            <img src="{{ $logo['logo'] }}" {{ $logo['image_dimensions'] }} alt="{{ $logo['alt'] }}" loading="lazy" class="mw-100" decoding="async">
          </{{ (empty($wrapperOverride) && !empty($logo['url'])) ? 'a' : 'div' }}>
        </div>
      @endforeach
    </{{ !empty($wrapperOverride) ? 'a' : 'div' }}>
  @endif

  @if($viewAllMobile && count($logos) > 9)
    <a href="#" class="show-all-mobile d-flex d-lg-none align-items-center text-center w-100 border-bottom border-blue-300 fs-14 fw-700 text-blue-400 mb-40 text-decoration-none justify-content-center p-8 pb-16" data-show="">
      <span>{!! $viewAllMobile !!}</span> <i class="fas fa-chevron-down ms-8"></i>
    </a>
  @else
    <hr class="w-100 d-flex d-lg-none border-blue-300 opacity-100 ">
  @endif

  <div class="text-greyscale-300 disclaimer-md text-center">
    {!! $disclaimer !!}
  </div>
</section>