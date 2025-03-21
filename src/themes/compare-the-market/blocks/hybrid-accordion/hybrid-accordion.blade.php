<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-hybrid-accordion" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
  <div class="container">
    <div class="row">
      <div class="col col-12">
        <x-title-block
          :acf="$title_block ?? []"
          :color="in_array($block_theme['background_colour'], ['theme-blue','theme-dark-blue']) ? 'text-white' : ''"
        />
      </div>
    </div>
    @foreach($accordions ?? [] as $id => $accordion)
      <x-ctm-accordion :block="$block_object" :id="$id" showTitle="Read more" hideTitle="Read less" class="theme-white">
        @php
          $header_type = $accordion['header_type'];
          $title = $accordion['accordion_header']['title'] ?? false;
          $title_type = $accordion['accordion_header']['title_type'] ?? false;
          $quote = $accordion['accordion_header']['quote_text'] ?? false;
          $author = $accordion['accordion_header']['author']['expert_label'] ?? false;
          $image = $accordion['accordion_header']['image']['image'] ?? false;
          $image_width = $accordion['accordion_header']['image_width'] ?? false;
          $content = $content = $accordion['accordion_body']['content'] ?? false;
        @endphp

        <x-slot name="header">
          {{-- Accordion Header --}}
          @include('Blocks::hybrid-accordion.headers.' . $header_type)
        </x-slot>
        {{-- Accordion Body --}}
        @include('Blocks::hybrid-accordion.content.' . $header_type)
      </x-ctm-accordion>
    @endforeach
  </div>
</x-block-theme>
