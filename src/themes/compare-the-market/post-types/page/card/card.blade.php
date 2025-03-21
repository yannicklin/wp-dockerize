<x-card class="card-post">
  <x-slot name="image">
    <div class="position-relative">
      <div class="tags">
        <x-tag title="Featured" class="tag-primary"/>
      </div>
      {{ get_the_post_thumbnail($post, 'post-thumbnail', array('class' => 'media media-landscape', 'loading' => 'lazy')) }}
    </div>
  </x-slot>
  <x-slot name="body">
    <div class="card-detail">
      <label class="text-6 text-grey">{{ get_the_date('F j, Y', $post) }}</label>
      <h5 class="card-title">{!! get_the_title($post) !!}</h5>
    </div>
    <x-button title="Read Article" :href="get_the_permalink($post)"/>
  </x-slot>
</x-card>
