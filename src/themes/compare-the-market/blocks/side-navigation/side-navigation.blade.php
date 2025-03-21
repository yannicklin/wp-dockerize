@if($blocks)
  @foreach($blocks as $index => $block)
    @php($block['block_theme'] = (['block_parent' => 'side-navigation'] + $block['block_theme']))
    @php($block['fields'] = $block)
    @if(is_null($block_classes[$index]))
      @continue
    @endif
    @push('blocks')
      @php($block_classes[$index]->render($block))
    @endpush
  @endforeach

  <x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-side-navigation" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
    <div class="container">
      <div class="row gy-30">
        <div class="col-12 col-lg-3">
          <div class="side-navigation-items-container">
            <div class="fw-400 pb-8 pt-2 text-blue-600 pb-lg-16 pt-lg-0">{{$side_navigation_heading}}</div>
            <div class="d-flex flex-column ps-lg-32 pb-24 pb-lg-10 side-navigation-items" style="--max-height:{{$max_height}}">
              @foreach($blocks as $index => $block)
                @php($hide_title = !empty($block['hide_title_in_side_navigation']) ? $block['hide_title_in_side_navigation'] : false)
                @php($sidenav_title = !empty($block['title']) ? $block['title'] : ($block['title_block']['title'] ?? ($block['primary_heading']) ?? ''))
                @if(is_null($block_classes[$index]) || $hide_title)
                  @continue
                @endif
                <a class="body-s py-8 py-lg-16 {{ $index == 0 ? 'pt-lg-0' : ''}}" data-section="{{$block['acf_fc_layout']}}-{{$index}}" href="#{{ $block_classes[$index]->getBlockHtmlId() }}">
                  {{$sidenav_title }}
                </a>
              @endforeach
            </div>
            <button type="button" class="pt-10 pb-26 show-more justify-content-center align-items-center gap-5 body-s fw-800 height-40 text-blue-400" aria-expanded="true">
              <span>Show more</span>
              <x-icon icon="chevron"/>
            </button>
          </div>
        </div>

        <div class="col-12 col-lg-9 side-navigation-blocks {{ ($enable_divider ?? false) ? 'has-divider' : '' }}">
          @stack('blocks')
        </div>
      </div>
    </div>
  </x-block-theme>
@endif