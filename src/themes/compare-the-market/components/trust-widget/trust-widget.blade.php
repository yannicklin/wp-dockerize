@if($trust_widget_toggle)
    @if($choose_widget === 'Trust widget')
        <section
            {{ $attributes->class($classes()) }}
            style="--colour:{{$widget_theme_bg}};--opacity:{{$trust_widget_opacity}}"
            data-autoload-component="TrustWidget">
            <x-aggregate-rating size="30"/>
            @php($rating_logos = $widget_theme_is_dark ? get_field('rating_logos','options') : get_field('rating_logos_dark','options'))
            @if($images = $rating_logos)
                @foreach($images as $image)
                    <x-image :image="$image['logo']['url']" :width="$image['logo']['width']" :height="$image['logo']['height']" :lazy="false" class="height-48 d-flex align-items-center" />
                @endforeach
            @endif
        </section>
    @else
        <section class="component-trust-list w-100">
            @if($card_color !== 'None')
                <div class="col-12 col-lg-11 p-lg-24 text-start p-16 pb-24 radius-s {{ $cardClasses }}">
            @else
                <div class="trust-list col-12 col-lg-11 pt-16 pt-lg-32 {{ in_array($background_colour, ['theme-white', 'theme-cream-white']) ? 'border-subtle' : 'border-reversed' }}">
            @endif
                @if(!empty($list_item_header))
                    <div class="body-s fs-lg-16 text-start {{ !empty($trust_lists) ? 'pb-4 pb-lg-16' : 'm-0' }}">
                        {!! $list_item_header !!}
                    </div>
                @endif

                @if(!empty($trust_lists))
                    <div class="list-item">
                        <ul class="listitems">
                            @foreach($trust_lists as $trust_list)
                                <li class="mb-12 mb-lg-24 list-inline-item body-s fs-lg-16 d-flex align-items-top">
                                    <span class="me-12">
                                        <i class="fa-regular fa-check text-blue-500 bg-blue-300 rounded-pill text-white d-inline-flex justify-content-center align-items-center height-md-24 width-md-24 width-20 height-20" aria-label="Check Icon"></i>
                                    </span>
                                    {{ $trust_list['trust_list'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </section>
    @endif
@endif

@if(!empty($trust_disclaimer))
    <div class="text-center text-md-start text-break disclaimer-sm
       {{ $trust_widget_toggle ? 'no-margin' : '' }} {{ in_array($background_colour, ['theme-white', 'theme-cream-white', 'theme-light-blue']) ? 'text-greyscale-300' : '' }}">
       {!! $trust_disclaimer !!}
    </div>
@endif