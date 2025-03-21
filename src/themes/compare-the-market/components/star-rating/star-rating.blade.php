<div {{ $attributes->class($classes()) }} data-autoload-component="StarRating">
  <svg class="d-none">
    <symbol id="large-star" width="41" height="40" viewBox="0 0 41 40" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M19.9999 0L24.4902 13.8196H39.021L27.2653 22.3606L31.7556 36.1802L19.9999 27.6392L8.24427 36.1802L12.7345 22.3606L0.978867 13.8196H15.5097L19.9999 0Z" fill="currentColor"/>
      <path d="M20.0211 0L20.021 13.8196V18.1818L20.0211 27.6392L8.2654 36.1802L12.7557 22.3606L1 13.8196H15.5308L20.0211 0Z" fill="currentColor"/>
    </symbol>
  <svg>

  <div class="star-rating position-relative d-inline-flex fs-{{$size}}" role="img"  aria-label="Rating is {{$rating}} out of 5" style="--rating:{{$rating}}">
    <div class="star-rating-base d-inline-flex">
      <svg viewBox="0 0 41 40" class=""><use xlink:href="#large-star"></use></svg>
      <svg viewBox="0 0 41 40" class=""><use xlink:href="#large-star"></use></svg>
      <svg viewBox="0 0 41 40" class=""><use xlink:href="#large-star"></use></svg>
      <svg viewBox="0 0 41 40" class=""><use xlink:href="#large-star"></use></svg>
      <svg viewBox="0 0 41 40" class=""><use xlink:href="#large-star"></use></svg>
    </div>
    <div class="star-rating-overlay overflow-hidden position-absolute left-0 top-0 d-flex">
      <svg viewBox="0 0 41 40" class="flex-shrink-0"><use xlink:href="#large-star"></use></svg>
      <svg viewBox="0 0 41 40" class="flex-shrink-0"><use xlink:href="#large-star"></use></svg>
      <svg viewBox="0 0 41 40" class="flex-shrink-0"><use xlink:href="#large-star"></use></svg>
      <svg viewBox="0 0 41 40" class="flex-shrink-0"><use xlink:href="#large-star"></use></svg>
      <svg viewBox="0 0 41 40" class="flex-shrink-0"><use xlink:href="#large-star"></use></svg>
    </div>
  </div>

</div>
