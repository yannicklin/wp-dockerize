<div class="col-md-12">
  @if($title)
    <{{ $title_type }} class="pt-24 pb-16 px-24 w-100 mb-0 text-blue-600">{{ $title }}</{{ $title_type }}>
  @endif
</div>
<div class="col-md-12">
  @if($quote || $author)
    <div class="pt-24 pb-16 px-24">
      @if($quote)
        <div class="d-flex flex-column flex-md-row align-items-start gap-16 ">
          <div class="h4 text-blue-600">
            {!! $quote !!}
          </div>
        </div>
      @endif
      @if($author)
        <x-expert-label :acf="$author" class="mt-24"/>
      @endif
    </div>
  @endif
</div>
