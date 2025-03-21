<section class="component component-social-icons" data-autoload-component="SocialIcons">
	<div class="row g-10 justify-content-start">
		@foreach($channels ?? [] as $channel)
				<div class="col flex-grow-0 px-4">
					<a class="social-link width-32 height-32 d-flex justify-content-center align-items-center text-blue-600 bg-white" href="{{ $channel['link']['url'] ?? '#' }}" target="{{ $channel['link']['target'] ?? '_blank' }}" rel="nofollow noopener" aria-label="View our {{ $channel['name'] ?? '' }} page">
						{!! $channel['icon'] !!}
					</a>
				</div>
		@endforeach
	</div>
</section>
