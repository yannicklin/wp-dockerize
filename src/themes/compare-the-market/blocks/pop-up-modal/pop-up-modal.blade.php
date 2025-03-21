<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-pop-up-modal" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}" data-popupmodal-choice="{{$choice}}" data-popupmodal-cookies="{{$cookies}}" data-popupmodal-modal-id="{{$modal_id}}" data-popupmodal-page-title="{{$page_title}}" data-popupmodal-selected-favicon="{{$selected_favicon}}" data-popupmodal-popup-class="{{$popup_class}}" data-popupmodal-emoji-favicon="{{$emoji_favicon}}" >
    <div id="{{ $modal_id }}" class="modal d-none position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center" style="background-color: {{ $backgroundcolor ? '#001464' : 'rgba(0, 0, 0, 0.4)' }}; z-index: 9999;">
        <div class="m-auto col-12 col-lg-7 px-lg-50">
            <div class="popupmodal mx-20 mx-lg-auto my-40 border bg-white radius-m p-24 d-flex flex-column position-relative" style="box-shadow: 8px 8px #B4D4f8;" >
                <div class="close-modal position-absolute top-0 end-0 mt-5 me-5 mt-md-16 me-md-16 z-3"><i class="fa-thin fa-circle-xmark"></i></div>
                <div class="overflow-hidden text-break w-100">
                    <x-title-block :acf="$title_block ?? []" />
                </div>
            </div>
        </div>
    </div>
</x-block-theme>
