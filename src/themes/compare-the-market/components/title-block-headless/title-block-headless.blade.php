@if(!$title->isEmpty() || !$subtitle->isEmpty() || !$content->isEmpty())
<section
  {{ $attributes->class(['component component-title-block mb-16 mb-lg-16']) }} data-autoload-component="TitleBlock">
  {{ $title }}
  {{ $subtitle ?? '' }}
  {{ $content }}
</section>
@endif
