{{--
  Template Name: Partner Page
  Template Post Type: page, post
--}}

@extends('layouts.app')
@php
  use Atlas\Taxonomies\Partner;
  use Atlas\Taxonomies\Vertical;

  $partner = Partner::getPartnerinPage($post);
  $vertical = Vertical::getVerticalinPage($post, true);
  $primary_heading = get_field('page_title') ?: '';
  $primary_heading = $primary_heading ?: $partner?->name . ' ' . $vertical->name;
  $subtitle = get_field('sub_title') ?: '';
  $partner_alive = Partner::checkPartnerExist($partner?->term_id, $vertical?->term_id);
  $cta_buttons = Vertical::getStandardHeroDefaultCTAs($vertical);
  $boilerplate = get_field('boilerplate', Vertical::$slug . '_' . $vertical?->term_id) ?: '';
  // Get the VERTICAL and PARTERNER PLACEHOLDER be replaced.
  $boilerplate = str_replace(['%%VERTICAL%%', '%%PARTNER%%'], [$vertical?->name, $partner?->name], $boilerplate);
@endphp

@section('content')
  <div class="pt-8 pb-32 pt-lg-40 pb-lg-80 position-relative border-bottom border-1 border-greyscale-094 theme-cream-white">
    <div class="container">
      <div class="row pb-24">
        <div class="col-md-12">
          @if(function_exists('yoast_breadcrumb'))
            {!! yoast_breadcrumb('<p id="breadcrumbs" class="mb-0 body-s">','</p>') !!}
          @endif
        </div>
      </div>
      <div class="row flex-column-reverse flex-lg-row text-center justify-content-between text-lg-start align-items-center my-32 my-lg-40">
        <div class="col-lg-8 mb-16">
          <div class="d-flex flex-column align-items-md-center align-items-lg-start gap-16">
              <h1 class="mb-0 fw-800">
                {!! $primary_heading !!}
              </h1>
              <h2 class="mb-0">
                {!! $subtitle !!}
              </h2>
              @exists($cta_buttons)
                <div class="row button-group mt-24">
                  <div class="col col-12">
                    <x-button-group :acf="$cta_buttons ?? []" class="d-inline-flex flex-column flex-md-row gap-10 w-100"/>
                  </div>
                </div>
              @endexists
          </div>
        </div>
        <div class="col-12 col-lg-4 logo-container mb-40 mb-lg-0">
          <div class="logo p-30 d-flex justify-content-center align-items-center radius-xs bg-greyscale-094">
            {!! do_shortcode('[partner type="logo" source="id" id="' . $partner?->term_id . '"]') !!}
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(!$partner_alive)
    <!-- Boilerplate Content -->
    <div class="container py-40">
        <div class="row">
          <div class="col-lg-8">
            {!! $boilerplate !!}
          </div>
        </div>
      </div>
    </div>
  @else
    @while(have_posts()) @php(the_post())
      @includeFirst([
        $singleViewName,
        'partials.content-single-' . get_post_type(),
        'partials.content-single'
      ])
    @endwhile
  @endif
@endsection

