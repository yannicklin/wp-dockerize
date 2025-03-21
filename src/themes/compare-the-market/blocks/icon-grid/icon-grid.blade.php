<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-icon-grid"
               data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="text-yellow-200 overflow-hidden">
          <x-icon icon="hand-drawn-star" class="fs-30 mb-8 hand-drawn-star"/>
        </div>

        <x-title-block-headless class="text-center">
          <x-slot name="title">
            @if($title = $title_block['title'])
              @php($title_type = $title_block['title_type'] ?? 'h2')
              <{{ $title_type }} class="h2 fw-400 {{ in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? 'text-white' : 'text-blue-500' }}">
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
              <p class="body-l {{ in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? 'text-white' : 'text-blue-600' }} mb-0">{!! $content  !!}</p>
            @endif
          </x-slot>
        </x-title-block-headless>

      </div>

      @foreach($cards ?: [] as $card)
        <div class="col-md-4 mb-40">
          <div class="d-flex flex-column align-items-center p-24">
            @if($icon = $card['icon'])
              <div class="fs-56">{!! $icon !!}</div>
            @endif
            @php($card_heading_type = $card['card_heading_type'] ?? 'p')
            <{{ $card_heading_type }} class="body-xxl fw-700 mb-8 text-center">
              {{ $card['card_heading'] }}
            </{{ $card_heading_type }}>
            <div class="body-m mb-0 text-center">
              {!! $card['description'] !!}
            </div>

            @if($button_link = $card['button_link'])

              @if($button_type === 'button')
                <x-button
                    :title="$button_link['title']"
                    :theme="$card['button_theme']"
                    :href="$button_link['url']"
                    class="mt-24"/>
                @else
                  @php($button_link['link'] = $button_link)
                  <x-link :acf="$button_link" class="mt-24"/>
                @endif
              @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>
</x-block-theme>
