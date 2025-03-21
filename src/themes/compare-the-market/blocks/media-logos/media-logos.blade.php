<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-partners" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        @if($title_section_exist)
          <x-title-block-headless class="text-center section-heading">
            <x-slot name="title">
              @if($title)
                <{{ $title_type }} class="h2 fw-400 text-blue-500">{!! $title !!}</{{ $title_type }}>
            @endif
            </x-slot>
            <x-slot name="subtitle">
              @if($subtitle)
                <{{ $subtitle_type }} class="h3 text-blue-600 mb-0">{!! $subtitle !!}</{{ $subtitle_type }}
            >
            @endif
            </x-slot>
            <x-slot name="content">
              @if($title_content)
                <p class="body-l text-blue-600 mb-0">{!! $title_content  !!}</p>
              @endif
            </x-slot>
          </x-title-block-headless>
        @endif
        <x-logos :logos="$logos" :randomize="$randomize" :disclaimer="$disclaimer" :view-all-mobile="$view_all_mobile ?? ''" :view-less-mobile="str_replace('all', 'less', $view_all_mobile) ?? ''" :headings="$title_section_exist" :wrapper-override="$wrapper_override_url" />
      </div>
    </div>
  </div>
</x-block-theme>
