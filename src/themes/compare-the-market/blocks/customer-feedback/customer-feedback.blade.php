<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-customer-feedback {{ $divider ? 'has-divider' : '' }}" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">

  <div class="animation-container d-none d-md-block">
    <x-image :image="get_template_directory_uri() . '/resources/images/meercat-arm.png'" :width="483" :height="223" alt="Meerkat Arm" class="animation-image position-absolute end-0" />
  </div>

  <div class="container py-40 py-lg-80">
    <div class="row justify-content-center">
      <div class="col col-12 col-lg-8">
        <x-title-block-headless class="text-center">
          <x-slot name="title">
            @if($title = $title_block['title'])
              @php($title_type = $title_block['title_type'] ?? 'h2')
              <{{ $title_type }} class="h2 fw-400 mb-8 mb-lg-24 {{ in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? 'text-white' : 'text-blue-500' }}">
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
              <div class="{{ in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? 'text-white' : 'text-greyscale-400' }} mb-0">{!! $content  !!}</div>
            @endif
          </x-slot>
        </x-title-block-headless>
      </div>
    </div>

    <div class="d-flex flex-column flex-lg-row align-items-center gap-48 py-48 py-lg-80">
      <div style="flex: 1 0 0%">
        @include('Blocks::customer-feedback.trust-card', ['trust_card' => $product_review, 'theme_bg' => $block_theme['background_colour']])
      </div>
      <div style="flex: 1 0 0%">
        <div class="display-2 text-center fw-800">
          {{ $trust_text  }}
        </div>
      </div>
      <div style="flex: 1 0 0%">
        @include('Blocks::customer-feedback.trust-card', ['trust_card' => $feefo,  'theme_bg' => $block_theme['background_colour'] ])
      </div>
    </div>

    <div class="row justify-content-center mb-48 mb-lg-0">
      <div class="col col-lg-8 text-center">
        <div class="body-s {{ in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? '' : 'text-blue-600' }}">Ratings as of {!! $data_date !!}.</div>
      </div>
    </div>

    @if($divider)
      <div class="divider d-block d-lg-none p-0 {{ in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? '' : 'text-blue-300' }}"></div>
    @endif

  </div>

  @if($divider)
    <div class="divider d-none d-lg-block py-16 {{ in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? '' : 'text-blue-300' }}"></div>
  @endif

</x-block-theme>
