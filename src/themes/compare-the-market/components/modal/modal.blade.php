<dialog {{ $attributes->class(['ctm-modal']) }}  data-autoload-component="Modal" role="dialog" aria-modal="true">
  <div {{ $body->attributes->class(['ctm-modal-content w-100 h-100 position-relative']) }}>
    <button class="ctm-modal-close-button cursor-pointer position-absolute mt-32 mx-32 d-flex justify-content-center align-items-center border border-2 border-white radius-round width-56 height-56 end-0">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18.3002 7.14521L13.3589 12.0865L18.259 16.9867C18.6708 17.3573 18.6708 17.9749 18.259 18.3455C17.8884 18.7573 17.2707 18.7573 16.9001 18.3455L11.9588 13.4454L7.05869 18.3455C6.68809 18.7573 6.07042 18.7573 5.69983 18.3455C5.28805 17.9749 5.28805 17.3573 5.69983 16.9455L10.6 12.0453L5.69983 7.14521C5.28805 6.77461 5.28805 6.15695 5.69983 5.74517C6.07042 5.37457 6.68809 5.37457 7.09986 5.74517L12 10.6865L16.9001 5.78635C17.2707 5.37457 17.8884 5.37457 18.3002 5.78635C18.6708 6.15695 18.6708 6.77461 18.3002 7.14521Z" fill="#001443"/>
      </svg>
    </button>
    <div class="container">
      <div class="row">
        <div class="col-md-12 py-100 p-lg-112">
          <div class="d-flex align-items-center justify-content-center"></div>
          {{ $body }}
        </div>
      </div>
    </div>
  </div>
</dialog>
