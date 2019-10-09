<div class="hd-profile-image">
    <div class="hd-profile-image-container">
		<div class="box hd-session-profile-image">
			<div class="item light hd-session-profile-image">
                <a href="#"><img class="hd-session-profile-image-img" src="{{ Auth::user()->getProfileImage() }}" alt="{{ Auth::user()->username }}" class="w-full" id="hd-profile-image"></a>
				<div id="hd-image-overlay" class="item-overlay black-overlay w-full">
					<a href="#" id="hd-open-profile-img-input" class="center text-md">
						<span id="hd-image-icon" class="lnr lnr-camera" style="font-size:45px; color:white;"></span>
						<span id="hd-image-load" style="display:none;"><i class="fa fa-spin fa-spinner" style="font-size:45px; color:white;"></i></span>
					</a>
					{!! Form::open(['url' => route('session.update.profile.image'), 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'hd-session-profile-image-update', 'data-image' => Auth::user()->getProfileImage() ]) !!}
						{!! Form::hidden('_method', 'PATCH') !!}
						{!! Form::file('image', ['id' => 'hd-profile-img-input', 'style' => 'display:none;', 'accept' => 'image/jpg, image/png, image/jpeg']) !!}
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>