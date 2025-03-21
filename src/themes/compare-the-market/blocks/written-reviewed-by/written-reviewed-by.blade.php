<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-written-reviewed-by" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
    @if (!$slim_verion)
        <section class="bg-blue-500 py-40">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex flex-column flex-lg-row">
                            @if($vertical_icon)
                                <div class="vertical-icon text-white d-flex width-56 height-56 width-md-80 height-md-80 bg-blue-400 radius-s align-items-center justify-content-center me-32">
                                    <x-icon :acf="$vertical_icon" class="fs-28 fs-md-40" />
                                </div>
                            @endif
                            <div class="d-flex flex-column mt-32 mt-lg-0">
                                @if($title)
                                    @php($title_type = $title_type ?? 'h2')
                                    <{{ $title_type }} class="h2 text-white mb-0">
                                        {{ $title }}
                                    </{{ $title_type }}>
                                @endif
                                @if($date_updated)
                                    @php($date_updated_type = $date_updated_type ?? 'span')
                                    <{{ $date_updated_type }} class="span d-flex body-s text-white mt-12">
                                        {{ $date_updated }}
                                    </{{ $date_updated_type }}>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="py-32 {{ $slim_verion ? 'slim_verion border-top border-bottom' : '' }}">
        <div class="container">
            <div class="col-md-12">
                <div class="d-flex flex-column flex-lg-row gap-16 gap-lg-40">
                    @if($written_by)
                        @include('Blocks::written-reviewed-by.author', ['user' => $written_by, 'label' => 'Written by'])
                    @endif
                    @if($reviewed_by)
                        @include('Blocks::written-reviewed-by.author', ['user' => $reviewed_by, 'label' => 'Reviewed by'])
                    @endif
                    @if($expert_reviewed_by)
                        @include('Blocks::written-reviewed-by.author', ['user' => $expert_reviewed_by, 'label' => 'Expert reviewed by'])
                    @endif

                    @if($slim_verion && $date_updated)
                        @php($date_updated_type = $date_updated_type ?? 'section ')
                        <{{ $date_updated_type }} class="date-updated-element position-relative d-flex body-s align-items-center ms-lg-auto my-lg-auto me-none ps-20 ps-lg-16 mt-12 {{ in_array($block_theme['background_colour'], ['theme-blue', 'theme-dark-blue']) ? 'border-white' : 'border-blue-300' }}">
                            {{ $date_updated }}
                        </{{ $date_updated_type }}>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-block-theme>
