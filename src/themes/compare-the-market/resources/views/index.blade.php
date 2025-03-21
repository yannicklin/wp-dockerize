@extends('layouts.app')

@section('content')
  @if (! have_posts())
      {!! __('Sorry, no results were found.', 'sage') !!}

    {!! get_search_form(false) !!}
  @endif
  @while(have_posts()) @php(the_post())
    @php(the_content())
  @endwhile

  {!! get_the_posts_navigation() !!}
@endsection

@section('sidebar')
  <x-sidebar/>
@endsection
