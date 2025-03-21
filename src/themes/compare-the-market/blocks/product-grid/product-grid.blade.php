<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-product-grid position-relative" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
  <div class="container">
    <div class="product-grid {{ $container_background_colour }} radius-l">

      @if($primary_verticals)
        <div class="product-grid-primary-verticals d-flex flex-wrap px-16 pt-24 p-lg-32 pb-16 pb-lg-16 gap-16">
        @foreach($primary_verticals as $primary_vertical)
          <a href="{{$primary_vertical['vertical_page_link']}}" class="product-grid-item radius-s border border-1.5 border-blue-300 position-relative overflow-hidden">
            @php($term = $primary_vertical['vertical_text'])
            @php($vertical_title = $term?->name)
            <div class="product-grid-item-icon-container position-absolute">
              <div class="product-grid-item-bg">
                <svg width="47" height="45" viewBox="0 0 47 45" fill="none" xmlns="http://www.w3.org/2000/svg" class="">
                  <ellipse cx="35.4668" cy="35.4667" rx="35.4668" ry="35.4667" transform="matrix(-1 0 0 1 46.2668 -26)" fill="currentColor"></ellipse>
                </svg>
              </div>
              @if(isset($primary_vertical['vertical_icon']['id']))
                <x-icon :icon="$primary_vertical['vertical_icon']['id']" class="product-grid-item-icon position-absolute text-white"/>
              @endif
            </div>
            <div class="product-grid-item-title position-relative p-18 ps-48 pe-26 p-lg-24 ps-lg-60 pe-lg-30 fw-600">{!! $vertical_title ?? '' !!}</div>
          </a>
        @endforeach
        </div>
      @endif

      <div class="d-flex d-md-none justify-content-center align-items-center mb-24">
        <button type="button"class="btn btn-text collapsed"><span>Compare more</span> <x-icon icon="chevron" class="ms-5 fs-20"/></button>
      </div>

      @if($secondary_verticals)
        <div class="product-grid-overflow-container overflow-hidden collapsed">
          <div class="product-grid-secondary-verticals d-flex flex-wrap p-16 p-lg-32 pt-0 pt-lg-0 gap-16">
            @foreach($secondary_verticals as $secondary_vertical)
              <a href="{{$secondary_vertical['vertical_page_link']}}" class="product-grid-item radius-xs border border-1.5 border-blue-300 position-relative d-flex justify-content-md-center align-items-center py-16 px-24 p-lg-24 gap-8">
                <div class="product-grid-item-icon">
                  @if(isset($secondary_vertical['vertical_icon']['id']))
                    <x-icon :icon="$secondary_vertical['vertical_icon']['id']" class="fs-20"/>
                  @endif
                </div>
                <div class="product-grid-item-title fw-600">{!! $secondary_vertical['vertical_text'] ?? '' !!}</div>
              </a>
            @endforeach
          </div>
        </div>
      @endif

    </div>
  </div>
</x-block-theme>
