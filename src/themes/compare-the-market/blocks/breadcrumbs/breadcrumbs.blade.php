<x-block-theme :name="$block_slug" :acf="$block_theme ?? []"
               class="block block-breadcrumbs py-16 py-md-32" data-autoload-block="{{ $block_class }}">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        @if(function_exists('yoast_breadcrumb'))
          {!! yoast_breadcrumb('<p id="breadcrumbs" class="mb-0">','</p>') !!}
        @endif
      </div>
    </div>
  </div>

</x-block-theme>
