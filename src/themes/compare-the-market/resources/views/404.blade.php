@extends('layouts.app')

@section('content')
<div class="container py-100">
  <div class="row justify-content-between">
    <div class="col-md-6">
      <div >
        <x-title-block class="mb-lg-40">
          <x-slot name="title">
            Oops -<br> We lost that page!
          </x-slot>
          <x-slot name="subtitle">
            404
          </x-slot>

          Sorry, the page you are looking for doesn't exist or has been moved. Here are some helpful links:
        </x-title-block>

        {!! get_search_form(false) !!}

        <div class="404-links mt-30">
          @forelse(get_field('404_links', 'options') ?: [] as $link)
            <x-button class="ps-0 mt-15" :acf="$link['button']"/>
            <p>{{ $link['description'] }}</p>
          @empty

          @endforelse
        </div>
      </div>
    </div>
    <div class="col-md-5 mt-40 mt-md-0">
      @if($image = get_field('404_image', 'options'))
        <x-image :image="$image['image']" :width="$image['image']['image']['width']" :height="$image['image']['image']['height']" class="media media-portrait" />
      @endif
    </div>
  </div>
</div>

@endsection
