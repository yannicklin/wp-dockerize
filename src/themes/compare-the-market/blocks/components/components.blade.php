<x-block-theme :acf="$block_theme ?? []" class="block block-components" name="components" data-autoload-block="{{ $block_class }}">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <h2>Buttons</h2>
      </div>
      @foreach($buttons as $size => $theme)
        <div class="col-md-12">
          <h2>{{ $size }}</h2>
        </div>
        <div class="col-md-12">
          <div class="row">
            @foreach($theme as $button)
              <div class="col" style="margin-bottom: 20px;">
{{--                <p><strong>Theme:</strong> <code>{{ $button['theme'] }}</code></p>--}}
{{--                <p><strong>Size:</strong> <code>{{ $button['size'] }}</code></p>--}}
{{--                <p><strong>Icon Position:</strong> <code>{{ $button['icon_position'] }}</code></p>--}}
                <x-button :acf="$button"/>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
    <div class="row">
      <div class="col-md-12">
        <h2>Tags</h2>
        <div class="row">
          @foreach(['regular', 'small'] as $size)
            @foreach(['default','blue','light-blue','white','success','warning','error'] as $type)
              <div class="col-md-2">
                <x-tag :type="$type" :size="$size" title="Tag" />
              </div>
            @endforeach
          @endforeach
        </div>
      </div>
    </div>
  </div>
</x-block-theme>
