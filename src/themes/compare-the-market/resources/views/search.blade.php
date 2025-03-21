@extends('layouts.app')

@section('content')

  <div class="container py-60">
    <div class="row g-30">

      @if (! have_posts())
        <div class="col-12">
        <p>{!! __('Sorry, no results were found.', 'sage') !!}</p>

        {!! get_search_form(false) !!}
        </div>
      @else

        <h2>{!! __('Results for ', 'sage') !!} <strong>"{!! the_search_query() !!}"</strong></h2>

        @while(have_posts()) @php(the_post())
          <div class="col-md-4">
            @include('PostTypes::' . get_post_type() . '.card.card', ['post' => get_post()])
          </div>
        @endwhile
      @endif
    </div>
    <div class="row mt-50">
      {!! get_the_posts_navigation([
      'prev_text' => 'Next Page',
      'next_text' => 'Previous Page',
      'screen_reader_text' => 'Search Results Navigation'
      ]) !!}
    </div>
  </div>

@endsection
