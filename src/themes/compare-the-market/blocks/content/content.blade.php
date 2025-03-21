<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-content" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
  <div class="container">
    <div class="row">
      <div class="col col-12">
        <x-title-block
          :acf="$title_block ?? []"
          :color="in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? 'text-white' : ''"
        />
      </div>
    </div>
    <div class="row">
      <div class="col col-12 rte">
        {!! $content !!}
      </div>
    </div>
    @exists($button_group)
    <div class="row mt-50">
      <div class="col col-12">
        <x-button-group :acf="$button_group ?? []" class="d-inline-flex gap-10 flex-wrap"/>
      </div>
    </div>
    @endexists

  </div>
</x-block-theme>
