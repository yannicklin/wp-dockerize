@php($small_logo_height = 40)

<header class="banner header-fixed" data-autoload-component="Header">
  <div class="header-top d-flex align-items-center overflow-hidden">
    <div class="container d-none d-lg-block">
      <div class="row">
        <div class="col-12">
          {!! wp_nav_menu([
            'theme_location' => 'header-top',
            'menu_class' => 'header-top-nav',
          ]) !!}
        </div>
      </div>
    </div>
  </div>

  <div class="header-main d-flex align-items-center theme-{{$header_theme}}">
    <div class="container main-navigation-container">
      <div class="row position-relative justify-content-start justify-content-lg-between align-items-center g-32">
        <div class="col">
          <button class="desktop-menu-toggle d-none d-lg-flex align-items-center gap-4 ps-md-0" type="button"
                  aria-controls="main-menu" aria-expanded="false" tabindex="0">
            Menu
            <x-icon icon="chevron" class="fs-20"/>
          </button>
          <button class="mobile-menu-toggle d-block d-lg-none d-xl-none" type="button" data-bs-toggle="offcanvas"
                  data-bs-target="#mobile-menu" aria-label="mobile menu" aria-controls="mobile-menu">
            <span></span>
          </button>
        </div>
        <div class="col-auto col-lg text-center">
          <a class="brand" href="{{ home_url('/') }}" aria-label="Homepage">
            @if($site_logo)
              <div class="site-logo d-block position-relative w-auto">
                <picture>
                  @if($small_logo)
                    <source media="(max-width: 375px)" srcset="{{ $small_logo['url'] }}" width="{{ $small_logo['width'] / $small_logo['height'] * $small_logo_height }}" height="{{$small_logo_height}}">
                  @endif
                  @if($mobile_logo)
                    <source media="(max-width: 767px)" srcset="{{ $mobile_logo['url'] }}" width="{{ $mobile_logo['width'] }}" height="{{ $mobile_logo['height'] }}">
                  @endif
                  <img src="{{ $site_logo['url'] }}" width="{{ $site_logo['width'] }}" height="{{ $site_logo['height'] }}" alt="{{ $site_logo['alt'] }}" loading="eager" decoding="async">
                </picture>
              </div>
            @endif
          </a>
        </div>
        <div class="col d-flex justify-content-end">
          @php(do_action('ctm-theme/header-right'))
        </div>
      </div>
    </div>
  </div>

  <!-- HEADER CTA -->

  @if($cta_enabled)
    <div class="header-cta d-flex align-items-center theme-{{$header_theme}}">
      <div class="container">
        <div
          class="row flex-row-reverse flex-lg-row position-relative justify-content-lg-start justify-content-lg-between align-items-center g-32">
          <div class="col-auto col-xl">
            <a class="brand" href="{{ home_url('/') }}" aria-label="Homepage">
              @if($site_logo)
                <div class="site-logo d-block position-relative w-auto">
                  <picture>
                    @if($small_logo)
                      <source media="(max-width: 767px)" srcset="{{ $small_logo['url'] }}" width="{{ $small_logo['width'] / $small_logo['height'] * $small_logo_height }}" height="{{$small_logo_height}}">
                    @endif
                    <img src="{{ $site_logo['url'] }}" width="{{ $site_logo['width'] }}" height="{{ $site_logo['height'] }}" alt="{{ $site_logo['alt'] }}" loading="eager" decoding="async">
                  </picture>
                </div>
              @endif
            </a>
          </div>
          <div class="col-auto text-center fw-600 d-none d-lg-block fs-20">
            {!! $cta_title !!}
          </div>
          <div class="col col-lg-auto col-xl d-flex align-items-center justify-content-center justify-content-lg-end">
            <div class="block-group">
              @if(!empty($cta_buttons))
                @foreach($cta_buttons as $button)
                  <x-button :acf="$button['button']"
                            class="{{ $button['show_for_mobile'] ? 'd-inline-flex' : 'd-none d-lg-inline-flex' }}"/>
                @endforeach
              @endif
            </div>
          </div>
          <div class="col-auto d-block d-lg-none d-xl-none">
            <button class="mobile-menu-toggle" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#mobile-menu" aria-label="mobile menu" aria-controls="mobile-menu">
              <span></span>
            </button>
          </div>
        </div>
      </div>
    </div>
  @endif
  <!-- END HEADER CTA -->

  <div class="navbar-wrapper" id="main-menu" aria-hidden="true">
    <div class="container">
      <x-main-nav :theme="$header_theme" />
    </div>
  </div>

  <div class="navbar-overlay fade"></div>
</header>