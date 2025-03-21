<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-video" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
  <div class="container">
    <div class="row">
      <div class="col col-12 {{ $text_alignment ?? '' }}">
        <x-title-block :acf="$title_block ?? []" :color="in_array($block_theme['background_colour'], ['theme-dark', 'theme-dark-blue']) ? 'text-white' : ''" />
        @if($expert_label)
        <x-expert-label :acf="$expert_label" class="mt-16" />
        @endif
      </div>
      @if($wistia_id ?? false)
      <div class="col-md-12 mt-32 mt-md-32 video-container position-relative">
        <script src="//fast.wistia.com/embed/medias/{{ $wistia_id }}.jsonp" async></script>
        <img src="{{ $thumbnail['url'] ?? '' }}" width="{{$thumbnail['width']}}" height="{{$thumbnail['height']}}" alt="{{ $thumbnail['alt'] ?? 'placeholder image for Wistia Video player' }}" srcset="{{ wp_get_attachment_image_srcset($thumbnail['id']) }}" loading="lazy" class="w-100 h-auto wistia-thumbnail" data-wistia-id="{{ $wistia_id }}" decoding="async">

        <div class="play-button-overlay position-absolute top-50 start-50 translate-middle z-2">
          <img src="{{ get_template_directory_uri() . '/resources/images/video-playbutton.png' }}" alt="Play Button" width="56" height="56" class="play-button h-auto width-56 width-lg-88">
        </div>

        <div class="w-100 h-auto wistia_embed wistia_async_{{ $wistia_id }} playerColor=666666 d-none">&nbsp;</div>
      </div>
    </div>
    <div class="row">
      <div class="transcript-container">
        <x-ctm-accordion :block="$block_object" :id="$id ?? uniqid()" showTitle="Transcript" hideTitle="Transcript">
          <div class="py-32 px-24 text-greyscale-400 bg-white">
            @if($transcript_title)
            <div class="text-blue-500 body-xl fw-700 mb-16">
              {!! $transcript_title !!}
            </div>
            @endif
            @if($transcript)
            {!! $transcript !!}
            @endif
          </div>
        </x-ctm-accordion>
      </div>
    </div>
    @endif
  </div>
</x-block-theme>
