<div class="hd-chat-messages-list">
	@if(count($messages) > 0 )
		<div class="hd-messages-container-else">
			@foreach($messages as $message)

				@if($message->userTo->id == Auth::user()->id && $message->userFrom->id == $user->id)

					<div class="hd-message-received">
						<div class="hd-message-content">
							@if(count($message->images) > 0)
							<div class="hd-message-image" id="hd-open-images-galery-{{ $message->id }}" data-id="{{ $message->id }}">
								<img src="{{ $message->images[0]->getImagePath() }}" style="margin-bottom:5px;" />
								@if(count($message->images) > 1)
									<div class="hd-message-images-count">
										<p>+{{ count($message->images) - 1 }}</p>
									</div>
								@endif
								<div id="hd-image-gallery-{{ $message->id }}">
									@foreach($message->images as $image)
									<a href="{{ $image->getImagePath() }}" title="Message Image"></a>
									@endforeach
								</div>
							</div>
							@elseif($message->address != null)
							<p class="hd-message-text"><span class="lnr lnr-map-marker"></span> <a id="hd-load-message-map-{{ $message->id }}" href="{{ route('session.text.message.load', $message->id) }}">{{ $message->address }}</a></p>
							<div class="hd-message-user-map" id="hd-message-user-map-{{ $message->id }}"></div>
							<script>loadMapMessage("hd-message-user-map-{{ $message->id }}", "{{ $message->address }}", "{{ $message->longitude }}", "{{ $message->latitude }}");$("#hd-load-message-map-{{ $message->id }}").magnificPopup({type: 'ajax'});</script>
							@elseif($message->is_text_message == true)
							<p class="hd-message-text">{!! \App\Http\Controllers\Utils\Helpers::sms($message->message, 200) !!}</p>
							<a style="margin-bottom:5px;" href="{{ route('session.text.message.load', $message->id) }}" id="hd-read-message-{{ $message->id }}" class="genric-btn success medium">Read More</a>
							@else
							<p class="hd-message-text">{!! $message->message !!}</p>
							@endif
							<p class="hd-message-date" id="hd-message-date-{{ $message->id }}" data-date="{{ $message->created_at }}"></p>
						</div>
						<div class="hd-message-user-image">
							<img src="{{ $message->userFrom->getProfileImage() }}" alt="{{ $message->userTo->username }}" />
						</div>
					</div>

				@elseif($message->userFrom->id == Auth::user()->id && $message->userTo->id == $user->id) 
					
					<div class="hd-message-sent">
						<div class="hd-message-content">
							@if(count($message->images) > 0)
							<div class="hd-message-image" id="hd-open-images-galery-{{ $message->id }}" data-id="{{ $message->id }}">
								<img src="{{ $message->images[0]->getImagePath() }}" style="margin-bottom:5px;" />
								@if(count($message->images) > 1)
									<div class="hd-message-images-count">
										<p>+{{ count($message->images) - 1 }}</p>
									</div>
								@endif
								<div id="hd-image-gallery-{{ $message->id }}">
									@foreach($message->images as $image)
									<a href="{{ $image->getImagePath() }}" title="Message Image"></a>
									@endforeach
								</div>
							</div>
							@elseif($message->address != null)
							<p class="hd-message-text"><span class="lnr lnr-map-marker"></span> <a id="hd-load-message-map-{{ $message->id }}" href="{{ route('session.text.message.load', $message->id) }}">{{ $message->address }}</a></p>
							<div class="hd-message-user-map" id="hd-message-user-map-{{ $message->id }}"></div>
							<script>loadMapMessage("hd-message-user-map-{{ $message->id }}", "{{ $message->address }}", "{{ $message->longitude }}", "{{ $message->latitude }}");$("#hd-load-message-map-{{ $message->id }}").magnificPopup({type: 'ajax'});</script>
                            @elseif($message->is_text_message == true)
							<p class="hd-message-text">{!! \App\Http\Controllers\Utils\Helpers::sms($message->message, 200) !!}</p>
							<a style="margin-bottom:5px;" href="{{ route('session.text.message.load', $message->id) }}" id="hd-read-message-{{ $message->id }}" class="genric-btn success medium">Read More</a>
                            @else
							<p class="hd-message-text">{!! $message->message !!}</p>
							@endif
							<p class="hd-message-date" id="hd-message-date-{{ $message->id }}" data-date="{{ $message->created_at }}"></p>
						</div>
						<div class="hd-message-user-image">
							<img src="{{ $message->userFrom->getProfileImage() }}" alt="{{ $message->userFrom->username }}" />
						</div>
					</div>
                @endif
                <script>$("#hd-message-date-{{ $message->id }}").setDate();$("#hd-read-message-{{ $message->id }}").magnificPopup({type: 'ajax'});$("#hd-open-images-galery-{{ $message->id }}").openImageGallery(); $("#hd-image-gallery-{{ $message->id }}").imagesGallery();</script>
			@endforeach
		</div>
	@endif
</div>
