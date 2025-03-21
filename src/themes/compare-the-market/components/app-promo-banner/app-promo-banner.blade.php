<x-promo-banner {{ $attributes->class([]) }}>
  <x-slot name="top">
    {{-- Icon wrapper --}}
    <div class="me-24">
      @if($icon['image'] ?? false)
        <x-image :image="$icon['image']" :width="64" :height="64" />
      @endif
    </div>
    <p class="h6 mb-0 fw-800 app-banner-text">
      {{ $text }}
    </p>
  </x-slot>

  <div class="app-button-container d-flex">
    @foreach($buttons ?: [] as $app_button)
      <x-link :acf="$app_button['link']" class="me-8 app-button-icon">
        <x-image :image="$app_button['image']" :width="$app_button['image']['image']['width']" :height="$app_button['image']['image']['height']" />
      </x-link>
    @endforeach
  </div>
</x-promo-banner>
