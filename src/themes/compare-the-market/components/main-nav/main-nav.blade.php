<nav class="navbar navbar-expand-lg navbar-light component component-main-nav p-0" data-autoload-component="MainNav">
  <div class="desktop-menu offcanvas offcanvas-end d-none" id="mobile-menu" data-bs-backdrop="false">
    <div class="offcanvas-body">

      {!! wp_nav_menu( array(
        'theme_location'  => 'header-main',
        'depth'           => 3, // 1 = no dropdowns, 2 = with dropdowns.
        'container'       => 'div',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => 'navbar-nav mr-auto dropdown gap-lg-40',
        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
        'walker'          => new Atlas\Core\Menu\BootstrapWalker,
    ) ) !!}
      {{-- Promo banner --}}
      @if($app_banner ?? false)
        <x-app-promo-banner :icon="$app_icon_image" :buttons="$app_buttons" :text="$app_banner_text" class="bg-blue-200 d-lg-none m-24 px-16 py-24"/>
      @endif
      @if($promo_banner ?? false)
        <x-promo-banner class="bg-blue-200 d-lg-none m-24 px-16 py-24">
          <x-slot name="top">
            <p class="body-l mb-0">
              {{ $promo_banner_text }}
            </p>
          </x-slot>
          <x-button :acf="$promo_banner_button['button']"/>
        </x-promo-banner>
      @endif
    </div>
  </div>
</nav>
