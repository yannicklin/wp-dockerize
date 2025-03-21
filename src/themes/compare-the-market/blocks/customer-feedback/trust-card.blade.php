<div class="trust-card text-center">
  <div class="display-3 mb-16"><strong>{{ $trust_card['rating'] ?? 0 }}</strong> / 5</div>

  <x-star-rating size="40" :rating="$trust_card['rating'] ?? 0"/>

  @php($rating_logo = in_array($theme_bg, ['theme-blue','theme-dark-blue']) ? ($trust_card['logo'] ?? []) : ($trust_card['logo_dark'] ?? []))
  @php($rating_colour = in_array($theme_bg, ['theme-blue','theme-dark-blue']) ? 'text-white' : 'greyscale-400')

  @if($rating_logo)
    @php($image_fix_height = 36)
    <div class="d-flex justify-content-center my-24 my-lg-32">
      <x-image :image="$rating_logo['url']" :width="$rating_logo['width'] / $rating_logo['height'] * $image_fix_height " :height="$image_fix_height" class="d-flex align-items-center" />
    </div>
  @endif

  <div class="body-s fw-bold {{$rating_colour}}">Based on {{ number_format($trust_card['number_of_reviews'], 0) ?? 0 }} reviews</div>

</div>
