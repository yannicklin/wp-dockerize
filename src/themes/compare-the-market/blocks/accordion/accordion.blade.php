<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" id="{{ $block_object->getBlockHtmlId() }}" class="block block-accordion position-relative overflow-hidden" data-autoload-block="{{ $block_class }}">

  @if($branded_curve == 'top' || $branded_curve == 'bottom')
    <div class="branded-curve position-absolute {{$branded_curve}}-0 text-{{$branded_curve_colour}} d-block">
      <svg width="1920" height="360" viewBox="0 0 1920 360" fill="none" xmlns="http://www.w3.org/2000/svg"
           preserveAspectRatio="none" style="min-width: 100%;" class="bg-{{ $branded_curve_offset_colour }}">
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

  <div class="container {{ $branded_curve == 'top' ? 'mt-50' : 'mb-50' }}">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-{{ (($width ?? 100) / 100) * 12 }}">
        <x-title-block
          class="text-center"
          :acf="$title_block ?? []"
          :color="in_array($block_theme['background_colour'], ['theme-blue', 'theme-dark-blue', 'theme-blue']) ? 'text-white' : ''"
        />
        <div class="accordion {{ $branded_curve !== 'none' ? ($branded_curve == 'bottom' ? 'pb-50' : 'pt-50') : '' }}">
          @foreach($items ?: [] as $accordion_item)
            <x-accordion-item :acf="$accordion_item['accordion_item']" :id="($block['id'] ?? uniqid()) . '-' . $loop->index"/>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</x-block-theme>
