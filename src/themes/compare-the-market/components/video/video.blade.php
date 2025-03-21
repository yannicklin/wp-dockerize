<section class="component component-video {{ $attributes->get('class') }}" data-autoload-component="Video">
  @if (!$autoplay)
    @exists($image_placeholder)
      <div class="video-placeholder">
        <div class="video-play-icon">
          <svg width="90" height="90" viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="90" height="90" rx="45" fill="white"/>
            <path d="M36.625 63.1328V26.4297L61.0938 44.7812L36.625 63.1328ZM44.7812 4C39.4258 4 34.1227 5.05484 29.1749 7.10429C24.2271 9.15374 19.7314 12.1577 15.9446 15.9446C8.29658 23.5925 4 33.9654 4 44.7812C4 55.5971 8.29658 65.97 15.9446 73.6179C19.7314 77.4048 24.2271 80.4088 29.1749 82.4582C34.1227 84.5077 39.4258 85.5625 44.7812 85.5625C55.5971 85.5625 65.97 81.2659 73.6179 73.6179C81.2659 65.97 85.5625 55.5971 85.5625 44.7812C85.5625 39.4258 84.5077 34.1227 82.4582 29.1749C80.4088 24.2271 77.4048 19.7314 73.6179 15.9446C69.8311 12.1577 65.3354 9.15374 60.3876 7.10429C55.4398 5.05484 50.1367 4 44.7812 4V4Z" fill="#122B71"/>
          </svg>
        </div>
        <x-image :image="$image_placeholder['image']" :width="$image_placeholder['image']['width']" :height="$image_placeholder['image']['height']" class="media" />
      </div>
      <template>
        @if ($video_type == 'file')
          <video controls="controls" >
            <source type="{{ $video_file['mime_type'] }}" src="{{ $video_file['url'] }}" />
          </video>
        @elseif ($video_type == 'embed')
          {!! $video_embed  !!}
        @endif
      </template>
    @else
      @if ($video_type == 'file')
        <video controls="controls">
          <source type="{{ $video_file['mime_type'] }}" src="{{ $video_file['url'] }}" />
        </video>
      @elseif ($video_type == 'embed')
        {!! $video_embed  !!}
      @endif
    @endexists
  @else
    @if ($video_type == 'file')
      <video autoplay muted loop>
        <source type="{{ $video_file['mime_type'] }}" src="{{ $video_file['url'] }}" />
      </video>
    @elseif ($video_type == 'embed')
      {!! $video_embed  !!}
    @endif
  @endif
</section>
