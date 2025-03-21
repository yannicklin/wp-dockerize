<div
  class="card-item border border-1.5 bg-white border-blue-300 radius-l px-24 pt-32 pb-40 px-lg-32  d-flex flex-column align-items-start">

  @if($icon_type == 'numbered')
    <div
      class="icon icon-numbered width-48 height-48 radius-round bg-blue-300 text-blue-500 fw-bolder d-flex align-items-center justify-content-center mb-24">
      {{ $index }}
    </div>
  @elseif($icon_type == 'font-awesome')
    <div
      class="icon fs-40 width-48 height-48 radius-round text-blue-400  d-flex align-items-center justify-content-center mb-24">
      {!! $card['icon'] !!}
    </div>
  @else
  @endif

  <{{$title_type ?? 'h3'}} class="h4 mb-24 fw-800 text-blue-600">{!! $card['heading'] !!}</{{$title_type ?? 'h3'}}>

  <div class="mb-16 text-blue-600">{!! $card['description'] !!}</div>



  @if($card['link_type'] == 'button')
    <x-button :acf="$card['button']['button']" class="mt-auto"/>
  @else
    <x-link :acf="$card['link']['link']" class="mt-auto"/>
  @endif
</div>
