<section class="d-flex align-items-center">
  @if($image = get_field('expert_profile_image', 'user_' . $user['ID'])['sizes']['thumbnail'] ?? false)
    <x-image :image="$image" :width="$author_avatar_size" :height="$author_avatar_size" :lazy="false" class="width-32 height-32 width-md-{{$author_avatar_size}} height-md-{{$author_avatar_size}} d-block radius-round overflow-hidden"/>
  @elseif(current_user_can( 'manage_options' ))
    <a href="/wp-admin/user-edit.php?user_id={{ $user['ID'] }}&wp_http_referer=%2Fwp-admin%2Fusers.php%3Fid%3D{{ $user['ID'] }}" target="_blank">
      Add an image for the expert
    </a>
  @endif
  <span class="body-s ms-16 {{ in_array($block_theme['background_colour'], ['theme-blue', 'theme-dark-blue']) ? 'text-white' : 'text-blue-600' }}">
    {{ $label }} <a class="{{ in_array($block_theme['background_colour'], ['theme-blue', 'theme-dark-blue']) ? 'link-light' : '' }}" href="{{ get_field('expert_burrow_url', 'user_' . $user['ID']) ?: '#' }}">{{ $user['display_name'] }}</a>
  </span>
</section>
