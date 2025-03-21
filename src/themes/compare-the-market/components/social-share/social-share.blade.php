<section class="component component-social-share" data-autoload-component="SocialShare">  
	<div class="row">
		@foreach($shares as $share)
			<div class="col">
				<a
				class='share-button-wrapper'
				href='{{ $share['url'] }}'
				target='_blank'
				rel='nofollow noopener'
				aria-label='share on {{ $share['label'] }}'
				>
					@if($icons[$share['channel']])
						<x-icon :acf="$icons[$share['channel']]" />
					@else 
						share on {{ $share['label'] }}
					@endif
				</a>
			</div>
		@endforeach
	</div>
</section>
