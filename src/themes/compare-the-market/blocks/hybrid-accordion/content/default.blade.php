<div class="py-32 px-24 pt-8 body-m text-greyscale-400">
  <div class="row">
    <div class="col-md-{{ $quote ? '7' : '12' }} rte">
      @if($content)
        {!! $content !!}
      @endif
    </div>
    @if($quote)
      <div class="col-md-5">
        <div class="d-flex flex-column flex-md-row align-items-start gap-16">
          <div class="fs-24">
            <x-icon class="text-blue-400" icon="quote-no-padding"/>
          </div>
          <div class="h4">
            {!! $quote !!}
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
