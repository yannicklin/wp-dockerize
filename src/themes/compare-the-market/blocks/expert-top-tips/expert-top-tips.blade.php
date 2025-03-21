<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-expert-top-tips"
               data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">

  <div class="container">
    @exists(collect($title_block)->only(['title', 'subtitle', 'content']))
    <div class="row mb-16">
      <div class="col col-12">
        <x-title-block
          :acf="$title_block ?? []"
          :color="in_array($block_theme['background_colour'], ['theme-blue', 'theme-dark-blue']) ? 'text-white' : ''"
        />
      </div>
    </div>
    @endexists
    @if($experts)
      <div class="expert-tips">
        @foreach($experts ?: [] as $index => $expert)
          <div class="expert-section border-bottom border-1.5 border-blue-300 {{ ($index > 0) ? 'pt-40' : ''}}">
            <x-expert-label :acf="$expert['expert_label'] ?? []"/>

            @foreach($expert['expert_tips'] ?: [] as $tip)
              <div class="expert-tip mt-32 mb-64">
                <div class="d-flex flex-column flex-md-row align-items-start gap-8 {{in_array($block_theme['background_colour'], ['theme-blue', 'theme-dark-blue']) ? '' : 'text-blue-600'}}">
                  <div class="expert-tip-icon fs-30">
                    <x-icon class="text-blue-400" icon="quote"/>
                  </div>
                  <div>
                    @if($quote_title = $tip['quote_title'])
                      <h3 class="h3 blockquote">{{ $quote_title }}</h3>
                    @endif
                    {!! $tip['quote_content'] !!}
                  </div>
                </div>
              </div>
            @endforeach

          </div>
        @endforeach
      </div>
    @endif
  </div>

</x-block-theme>
