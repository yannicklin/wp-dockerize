<section data-toggle="{{ $block->getBlockHtmlId() . '-' . $id }}-expand" {{ $attributes->class(['component component-ctm-accordion border border-blue-300 border-1.5 radius-s mb-32 overflow-hidden theme-white text-blue-500']) }} data-autoload-component="CtmAccordion" data-read-more="{{ $showTitle }}" data-read-less="{{ $hideTitle }}">
  <div class="row">
    @isset($header)
      {{ $header }}
    @endisset
    <div class="col-md-12">
      <div class="ctm-accordion-content collapsed" id="{{ $block->getBlockHtmlId() . '-' . $id }}">
        {!! $slot !!}
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      {{-- Accordion Expand/Hide button --}}
      <button class="bg-blue-200 w-100 border-0 text-blue-400 py-12 fw-700 collapsed"
              id="{{ $block->getBlockHtmlId() . '-' . $id }}-expand"
              aria-expanded="false"
              aria-controls="{{ $block->getBlockHtmlId() . '-' . $id }}"
              data-toggle-id="{{ $block->getBlockHtmlId() . '-' . $id }}">
        <span class="me-8">{{ $showTitle }}</span>
        <svg width="18" height="11" viewBox="0 0 18 11" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M17.3571 2.45239L9.68304 9.80507C9.44196 10.006 9.20089 10.0863 9 10.0863C8.75893 10.0863 8.51786 10.006 8.31696 9.84525L0.602679 2.45239C0.200893 2.09079 0.200893 1.44793 0.5625 1.08632C0.924107 0.684536 1.56696 0.684536 1.92857 1.04614L9 7.79614L16.0312 1.04614C16.3929 0.684536 17.0357 0.684536 17.3973 1.08632C17.7589 1.44793 17.7589 2.09079 17.3571 2.45239Z" fill="#0F58AB"/>
        </svg>
      </button>
    </div>
  </div>
</section>
