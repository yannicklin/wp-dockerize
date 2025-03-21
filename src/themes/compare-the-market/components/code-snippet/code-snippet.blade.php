@foreach($snippets ?: [] as $snippet)
  <!-- Snippet Name: {{ $snippet['name'] }} -->
  {!! $snippet['code'] !!}
@endforeach
