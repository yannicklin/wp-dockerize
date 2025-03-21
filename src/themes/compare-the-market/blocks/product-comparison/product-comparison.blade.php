<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-product-comparison"
    data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
    <div class="container">
        <!-- Title block -->
        <div class="mb-24 mb-lg-48 section-heading overflow-hidden text-center pe-10 pe-md-0">
            <x-title-block :acf="$title_block ?? []" :color="in_array($block_theme['background_colour'], ['theme-blue', 'theme-dark-blue', 'theme-dark'])
                ? 'text-white'
                : 'text-blue-600'" />
        </div>

        <!-- Tab Titles Nav -->
        <div class="d-flex justify-content-center">
            <ul class="tab-border list-unstyled p-8 d-inline-flex overflow-hidden rounded-pill bg-white mb-0"
                id="productComparisonTabs">
                @foreach ($tabs as $index => $tab)
                    <li class="bg-white nav-item">
                        <a class="p-12 radius-xl body-m nav-link
                        @if ($index == 0) text-blue-500 bg-blue-300 active 
                        @else
                            bg-white @endif"
                            id="tab-{{ $index }}-tab" href="#tab-{{ $index }}"
                            aria-controls="tab-{{ $index }}"
                            aria-selected="@if ($index == 0) true @else false @endif">
                            {{ $tab['Tab-title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Cards -->
    <div class="tab-content container-lg" id="productComparisonTabsContent">
        @foreach ($tabs as $index => $tab)
            <div class="tab-pane fade @if ($index == 0) show active @endif" id="tab-{{ $index }}"
                aria-labelledby="tab-{{ $index }}-tab">
                <div class="swipercomparison overflow-hidden">
                    <div class="swiper-wrapper mx-md-0 row g-24 g-lg-40 justify-content-lg-center flex-nowrap flex-lg-wrap">
                        @foreach ($tab['cards'] as $card)
                            @php
                                $button_group = $card['button_group']['button_group'] ?? null;
                            @endphp
                            <div class="swiper-slide col-md-4 pe-0 ps-24 ps-md-20 pe-md-20 me-0">
                                <div
                                    class="card-item mt-40 mt-lg-64 text-primary border border-1.5 bg-alabaster-200 border-blue-300 radius-m px-16 pt-24 pb-32 px-lg-24 py-lg-32 d-flex flex-column align-items-start position-relative">
                                    @if ($card['top pick'])
                                        <img src="{{ get_template_directory_uri() . '/resources/images/icons/topbadge.svg' }}"
                                            alt="Top Pick" width="105" height="107" class="badge-top-pick position-absolute h-auto">
                                    @endif

                                    <x-image :image="$card['image']"/>
                                    <h3 class="h4 mb-16">
                                        <a href="{{ esc_url($card['Title_link']) }}" class="fw-800 text-blue-600 text-break text-decoration-underline opacity">
                                            {{ $card['heading'] }}
                                        </a></h3>
                                    <p class="mb-32 body-m text-break text-greyscale-400">{{ $card['description'] }}</p>

                                    <div class="listitems text-break">
                                        <ul class="ps-0 mb-neg-16">
                                            @foreach ($card['listitem'] as $listItem)
                                                <li
                                                    class="mb-16 list-inline-item body-m text-greyscale-400 d-flex align-items-top">
                                                    <span class="me-12">
                                                        {!! $listItem['icon_type'] === 'Check' 
                                                            ? '<i class="fa-regular fa-check bg-apple-300 fs-12 rounded-pill text-white d-inline-flex justify-content-center align-items-center height-20 width-20" aria-label="Yes"></i>'
                                                            : '<i class="fa-regular fa-xmark text-crimson-200 fs-12 bg-crimson-100 rounded-pill d-inline-flex justify-content-center align-items-center height-20 width-20" aria-label="No"></i>'
                                                        !!}
                                                    </span>
                                                    {{ $listItem['List Item Text'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    @if ($button_group)
                                        <x-button-group :acf="$button_group ?? []"
                                            class="gap-8 pt-32 pt-lg-40 w-100 mt-auto d-flex flex-column" />
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-block-theme>