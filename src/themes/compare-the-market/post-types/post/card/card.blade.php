<section class="card card-post ">
  <a href="{{ get_field('burrow_url', $post) ?: get_permalink($post)}}" class="text-decoration-none p-24 d-flex flex-md-row flex-column radius-s border border-blue-300 border-1.5 mb-24 bg-white">
     <div class="order-2 order-md-1 d-flex justify-content-between flex-column w-100 w-md-75">
      <div class="d-flex flex-column">
        @if($category = get_the_category($post)[0]->name ?? false)
          <label class="text-uppercase body-s fw-600 mb-8 text-blue-400">
            {{ $category }}
          </label>
        @endif
        <span class="h4 fw-600 body-xl mb-16 text-blue-500 text-break">{{ get_the_title($post) }}</span>
        <div class="body-m fw-500 mb-16 text-blue-600 pe-0 pe-md-40 text-truncate">{{ get_the_excerpt($post) }}</div>
      </div>
      <time class="body-xs fw-600 text-blue-600">{{ get_the_date('F j, Y', $post) }}</time>
    </div>
    {{ get_the_post_thumbnail($post, 'post-thumbnail', array('class' => 'order-1 order-md-2 mb-24 mb-md-0 d-flex w-md-25 w-100 radius-s overflow-hidden ml-md-40', 'loading' => 'lazy')) }}
  </a>
</section>