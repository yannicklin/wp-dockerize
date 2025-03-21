<section
  {{ $attributes->class('component component-promo-banner d-flex flex-column align-items-start radius-xs') }}>
  <div class="mb-32 d-flex align-items-center">
    {{ $top }}
  </div>
  <div class="d-flex">
    {{ $slot }}
  </div>
</section>
