<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-posts"
               data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}" data-pages="{{ count(collect($posts)->chunk($per_page)) }}">
  <div class="container">
    <div class="row">
      <div class="col-md-12  mb-16 mb-lg-16">
        <x-title-block
          class="{{ $text_alignment ?? 'text-center' }}"
          :acf="$title_block ?? []"
          :color="in_array($block_theme['background_colour'], ['theme-blue', 'theme-dark-blue', 'theme-blue']) ? 'text-white' : ''"
        />
      </div>
      @if($paginate)
        @foreach(collect($posts)->chunk($per_page) as $page => $chunk)
          <div class="col-md-12 post-page-container {{ $page > 0 ? 'd-none' : '' }}" data-page="{{ $page + 1 }}">
            @foreach($chunk as $found_post)
              @include('PostTypes::' . $found_post->post_type . '.card.card', ['post' => $found_post])
            @endforeach
          </div>
        @endforeach
        <div class="col-md-12">
          <div class="pagination d-flex justify-content-center mt-20">
            <a href="#" title="Previous page" class="btn btn-secondary btn-lg btn-previous width-40 height-40 d-flex justify-content-center align-items-center">
              <i class="fa-regular fa-chevron-left"></i>
            </a>
            @foreach(collect($posts)->chunk($per_page) as $page => $chunk)
              <a href="#" title="Go to page {{ $loop->index + 1 }}" class="btn {{ $loop->index ? 'btn-secondary' : 'btn-primary' }} btn-lg width-40 height-40 mx-5 d-flex justify-content-center align-items-center" data-page="{{ $loop->index + 1 }}">
                {{ $loop->index + 1 }}
              </a>
            @endforeach
            <a href="#" title="Next page" class="btn btn-secondary btn-lg btn-next width-40 height-40 d-flex justify-content-center align-items-center">
              <i class="fa-regular fa-chevron-right"></i>
            </a>
          </div>
        </div>
      @else
        <div class="col-md-12">
          @foreach($posts as $found_post)
            @include('PostTypes::' . $found_post->post_type . '.card.card', ['post' => $found_post])
          @endforeach

          @if($view_all)
            <div class="d-flex justify-content-center">
              <x-button :acf="$view_all['button'] ?? []"/>
            </div>
          @endif
        </div>
      @endif
    </div>
  </div>
</x-block-theme>
