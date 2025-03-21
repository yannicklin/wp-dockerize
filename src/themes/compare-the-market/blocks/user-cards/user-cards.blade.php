<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-user-cards" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
  <div class="container overflow-hidden">

    <div class="row">
      <div class="col col-12">
        <x-title-block-headless class="mb-40 mb-lg-40 text-break text-{{ $alignment }}">
          <x-slot name="title">
            @if($title = $title_block['title'])
              @php($title_type = $title_block['title_type'] ?? 'h2')
              <{{ $title_type }} class="h2 mb-8 fw-bold {{ in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? 'text-white' : 'text-blue-500' }}">
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
              <div class="{{ in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? 'text-white' : 'text-greyscale-400' }}">{!! $content  !!}</div>
            @endif
          </x-slot>
        </x-title-block-headless>
      </div>
    </div>

    <div class="d-flex flex-column gap-40">

    @foreach($row ?? [] as $row_item)
      @if($row_item['title'])
      <div class="row">
        <div class="col-12">
          <{{$row_item['title_type']}} class="h4 mb-0 fw-800 text-break">
            {{$row_item['title']}}
          </{{$row_item['title_type']}}>
        </div>
      </div>
      @endif
        <div class="row g-30 row-cols-1 row-cols-lg-3 user-cards-row">
        @foreach($row_item['user_cards'] ?? [] as $user_card)

          <div class="col flex-grow-1">

            @if($row_item['card_titles'])
            <div class="mb-16 {{in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? 'text-white' : 'text-blue-500'}}">
              <{{$user_card['title_type']}} class="h5 fw-800 mb-0 text-truncate">{{$user_card['card_title']}}</{{$user_card['title_type']}}>
              <{{$user_card['subtitle_type']}} class="body-m text-truncate">{{$user_card['card_subtitle']}}</{{$user_card['subtitle_type']}}>
            </div>
            @endif

            <div class="user-card bg-white border border-blue-300 radius-s p-24">
              <div class="d-flex flex-column flex-lg-row gap-20">
                <div>
                  @if($user_card['profile_image'])
                    <x-image :image="$user_card['profile_image']['sizes']['thumbnail']" :width="$userprofile_image_size" :height="$userprofile_image_size" :lazy="false" class="d-block radius-round overflow-hidden user-card-image"/>
                  @endif
                </div>

                <div>
                  <div class="h5 mb-0 text-blue-500 fw-800">{{$user_card['name']}}</div>
                  @if($user_card['role'])
                    <div class="body-m mt-4 text-blue-600">{{$user_card['role']}}</div>
                  @endif

                  @if ($user_card['email'] || $user_card['phone'])
                    <div class="d-flex gap-24 mt-8">
                      @if($user_card['email'])
                        <div><a class="d-flex align-items-center gap-8 fs-14" href="mailto:{{$user_card['email']}}"><x-icon icon="mail" class="fs-18"/> Email</a></div>
                      @endif
                      @if($user_card['phone'] )
                        <div><a class="d-flex align-items-center gap-8 fs-14" href="tel:{{$user_card['phone']}}"><x-icon icon="phone-inverted" class="fs-18"/> Phone</a></div>
                      @endif
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach

      </div>
      @if($row_item['add_divider'])
        <div class="mt-24"><div class="bg-blue-300" style="height: 1px;width:100%"></div></div>
      @endif
    @endforeach
    </div>
  </div>
</x-block-theme>
