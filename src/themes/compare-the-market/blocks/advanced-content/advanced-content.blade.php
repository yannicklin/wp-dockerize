<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-advanced-content" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
  <div class="container">
    <div class="d-flex flex-column gap-40">
  
      @foreach($rows as $row)
        <div class="row justify-content-center g-0 ">
  
          <div class="col-12 col-lg-{{ ($row['row_width'] / 100) * 12 }}">
            <div class="row justify-content-{{ $row['horizontal_alignment'] }} align-items-{{ $row['vertical_alignment'] }} g-{{$row['row_gap']}}">
  
              @foreach($row['columns'] as $column)
  
                <div class="col-12 col-lg-{{$column['column_width']}}">
  
                  <x-banner-card class="overflow-hidden text-break {{$column['custom_class']}} {{ $column['add_border'] ? $column['border_style'] : 'border-0' }}" :padding="$column['card_padding']" :background="$column['column_colour']" :type="$column['border_style']" :rounded="$column['border_radius']">
                    @if($column['image'])
                      <x-image :image="$column['image']" :width="$column['image']['width']" :height="$column['image']['height']" />
                    @else
                      <div class="rte">
                        {!! $column['content']  !!}
                      </div>
                    @endif
                  </x-banner-card>
  
                </div>
  
              @endforeach
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  </x-block-theme>