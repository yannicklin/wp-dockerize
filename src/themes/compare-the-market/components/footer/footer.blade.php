<footer class="component-footer bg-blue-500 py-40 py-lg-80">
  <div class="container">
    <div class="row">
      <div class="col-xl-6 mb-64 text-white">
        <div class="row footer-top">
          @foreach($footer_top_columns ?: [] as $footer_top_column)
            <div class="col">
              {!! $footer_top_column['navigation_menu'] !!}
            </div>
          @endforeach
        </div>
      </div>
      <div class="offset-xl-3 col-xl-3 mb-64">
        <div class="d-flex flex-column justify-content-between h-100">
          <x-app-promo-banner :icon="$app_icon_image" :buttons="$app_buttons" :text="$app_banner_text" class="text-white ps-0 ms-0 my-0 py-0"/>
          <div class="mt-80 mt-xl-0">
            @if($text = get_field('social_media_icons_text', 'options'))
              <span class="body-l fw-700 text-white mb-16 d-flex">
                {{ $text }}
              </span>
            @endif
            <x-social-icons/>
          </div>
        </div>
      </div>
      <div class="col-md-12 mb-64">
        <div class="accordion">
          @if($footer_menu_text ?? false)
            <p class="body-xl fw-700 text-white mb-16">
              Looking for something else?
            </p>
          @endif
          @foreach($footer_menu_accordion ?: [] as $accordion_item)
            <x-accordion-item :acf="$accordion_item" :id="'footer-menu-accordion-' . $loop->index"/>
          @endforeach
        </div>
      </div>
      <div class="col-md-12 text-white footer-text disclaimer-sm">
        {!! $disclaimer !!}
      </div>
    </div>
  </div>
</footer>
@stack('footer:scripts')
