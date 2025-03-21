<div class="claim bg-white border-blue-300 radius-l py-32 py-lg-24 px-24 d-flex flex-column flex-lg-row justify-content-start text-blue-600 align-items-start">
  <div class="rte px-0 mb-16 mb-lg-0 align-self-start order-first order-lg-last">
      @if(!empty($card['image']))
        <x-image :image="$card['image']['url']" :width="$card['image']['width']" :height="$card['image']['height']" class="radius-s media alignright width-64 width-md-112 width-xl-224 height-64 height-md-112 height-xl-224" />
      @else
        <x-image :image="get_template_directory_uri() . '/resources/images/meerkat-avatar.png'" :width="224" :height="224" class="radius-s media alignright width-64 width-md-112 width-xl-224 height-64 height-md-112 height-xl-224" />
    @endif
  </div>
  <div class="col me-0 me-md-32 me-xl-64 px-0 flex-column">
    <h4 class="body-xl mb-0">{!! $card['subtitle'] !!}</h4>
    <div class="saving-amount mb-16 mb-lg-24" start="0" end="{!! $card['saving_amount'] !!}" duration="1500">0</div>
    <div class="body-m">{!! $card['description'] !!}</div>
  </div>
</div>
