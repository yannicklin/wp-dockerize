{{-- https://getbootstrap.com/docs/5.0/components/accordion/ --}}
<section class="component component-accordion-item accordion-item" data-autoload-component="AccordionItem">
  <p class="accordion-header" id="heading-{{ $id }}">
    <button class=" body-l text-white fw-700 accordion-button {{ $open_on_load ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $id  }}" aria-expanded="false">
      {{ $title }}
    </button>
  </p>
  <div id="collapse-{{ $id }}" class="accordion-collapse collapse {{ $open_on_load ? 'show' : '' }}" aria-labelledby="heading-{{ $id }}">
    <div class="accordion-body position-relative">
      {!! $content !!}
    </div>
  </div>
</section>
