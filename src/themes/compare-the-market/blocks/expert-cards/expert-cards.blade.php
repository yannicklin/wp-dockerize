@php
  $verticals = get_the_terms(get_the_ID(), 'vertical');
  $vertical = $verticals[0] ?? [];
  $expertprofile_image_size = 90;
@endphp

<x-block-theme :acf="$block_theme ?? []" :name="$block_object->name" class="block block-expert-cards" data-autoload-block="{{ $block_class }}" id="{{ $block_object->getBlockHtmlId() }}">
  <div class="container">

    <x-title-block
      :acf="$title_block ?? []"
      :color="in_array($block_theme['background_colour'], ['theme-blue', 'theme-dark-blue']) ? 'text-white' : ''"
    />

    <div class="d-flex flex-column gap-24">

    @foreach($expert_cards as $expert_card)
      @php
        $userToggle = $expert_card['user_toggle'];
        if($userToggle == 'user') {
            $user = $expert_card['user'];
            $userVerticals =  get_field('verticals', 'user_' . $user['ID']) ?? [];
            $currentVerticalDescription = [];

            if(!empty($userVerticals) && !empty($vertical)) {
              foreach ($userVerticals as $key => $value) {
                  if ($value['vertical']->term_id == $vertical->term_id) {
                      $currentVerticalDescription = $value;
                      break;
                  }
              }
            }

            $name = $user['display_name'] ?? [];
            $area_of_expertise = get_field('expert_title', 'user_' . $user['ID']) ?? '';
            $image = get_field('expert_profile_image', 'user_' . $user['ID']) ?? [];
            $description = $currentVerticalDescription['user_description'] ?? '';
            $url = get_field('expert_burrow_url', 'user_' . $user['ID']) ?? '';
        } else {
            $name = $expert_card['name'] ?? [];
            $area_of_expertise = $expert_card['area_of_expertise'] ?? '';
            $image = $expert_card['profile_image'] ?? [];
            $description = $expert_card['description'] ?? '';
            $url = $expert_card['expert_burrow_url'] ?? '';
        }
      @endphp
      <section class="expert-card bg-alabaster-300 text-blue-500 radius-s p-24">
        <div class="row gap-24 gap-md-0">
          <div class="col-12 col-md-3">
            <div class="expert-image d-block position-relative w-auto">
              @if($image)
                <x-image :image="$image['sizes']['thumbnail']" :width="$expertprofile_image_size" :height="$expertprofile_image_size" class="d-block radius-round overflow-hidden width-{{$expertprofile_image_size}} height-{{$expertprofile_image_size}} mb-30"/>
              @endif
            </div>
            @if (!empty($url))
              <a href="{{$url}}" class="body-xl text-blue-500 fw-bold expert-name text-decoration-none">
                {{$name}}
              </a>
              @else
              <div class="body-xl text-blue-500 fw-bold expert-name">
                {{$name}}
              </div>
              @endif
            <div class="body-s text-blue-500 expert-area">{{$area_of_expertise}}</div>
          </div>

          <div class="col-12 col-md-9">
            <div class="expert-description pt-24 pt-md-0 px-md-40 text-break">{!! $description !!}</div>
          </div>
        </div>
      </section>
      @endforeach
    </div>
  </div>
</x-block-theme>
