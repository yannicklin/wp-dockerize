<div {{ $attributes->class($classes()) }} data-autoload-component="AggregateRating">
  <svg class="d-none">
    <symbol id="star" width="23" height="22" viewBox="0 0 23 22" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
      <path d="M9.59789 1.85373C10.1966 0.0111103 12.8034 0.0111136 13.4021 1.85373L14.6432 5.6734C14.9109 6.49744 15.6789 7.05536 16.5453 7.05536H20.5615C22.499 7.05536 23.3045 9.53459 21.7371 10.6734L18.4879 13.0341C17.7869 13.5434 17.4936 14.4461 17.7614 15.2701L19.0024 19.0898C19.6012 20.9324 17.4922 22.4647 15.9248 21.3259L12.6756 18.9652C11.9746 18.4559 11.0254 18.4559 10.3244 18.9652L7.07523 21.3259C5.5078 22.4647 3.39885 20.9324 3.99755 19.0898L5.23863 15.2701C5.50638 14.4461 5.21306 13.5434 4.51209 13.0341L1.26289 10.6734C-0.304538 9.53459 0.501016 7.05536 2.43846 7.05536H6.45469C7.32115 7.05536 8.08906 6.49744 8.3568 5.6734L9.59789 1.85373Z" fill="currentColor"/>
    </symbol>
  </svg>

  <div class="star-rating position-relative d-inline-flex fs-{{$size}}" role="img" aria-label="Rating is {{$aggregate_rating}} out of 5" style="--rating:{{$aggregate_rating}}">
    <div class="star-rating-base d-inline-flex">
      <svg viewBox="0 0 23 22" class=""><use xlink:href="#star"></use></svg>
      <svg viewBox="0 0 23 22" class=""><use xlink:href="#star"></use></svg>
      <svg viewBox="0 0 23 22" class="3"><use xlink:href="#star"></use></svg>
      <svg viewBox="0 0 23 22" class=""><use xlink:href="#star"></use></svg>
      <svg viewBox="0 0 23 22" class=""><use xlink:href="#star"></use></svg>
    </div>
    <div class="star-rating-overlay overflow-hidden position-absolute left-0 top-0 d-flex">
      <svg viewBox="0 0 23 22" class="flex-shrink-0"><use xlink:href="#star"></use></svg>
      <svg viewBox="0 0 23 22" class="flex-shrink-0"><use xlink:href="#star"></use></svg>
      <svg viewBox="0 0 23 22" class="flex-shrink-0"><use xlink:href="#star"></use></svg>
      <svg viewBox="0 0 23 22" class="flex-shrink-0"><use xlink:href="#star"></use></svg>
      <svg viewBox="0 0 23 22" class="flex-shrink-0"><use xlink:href="#star"></use></svg>
    </div>
  </div>

  <div class="disclaimer-sm">Average customer rating: {{$aggregate_rating}}/5</div>

</div>
