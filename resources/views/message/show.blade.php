@extends('layouts.app')

@section('content')
<section class="hd-session-main hd-messages">
	<div class="hd-messages-list">
		<h3>Messages</h3>
		<div class="hd-messages-list-all">
			<div id="hd-messages-all"><span class="hd-spinner" style="display:block; margin-top:100px;"><i class="fa fa-spin fa-spinner"></i></span></div>
		</div>
	</div>
	<div class="hd-session-container hd-messages-all">
		<div class="hd-about">
			<div class="hd-image"><img src="{{ $user->getProfileImage() }}" alt="{{ $user->username }}" /></div>
            <h3>{{ $user->name }} <span>@<span>{{ $user->username }}</span></span></h3>
            <p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
        </div>
		<div class="hd-messages-container" id="hd-chat-messages-container"><span class="hd-spinner" style="display:block; margin-top:100px;"><i class="fa fa-spin fa-spinner"></i></span></div>
		<div class="hd-type-status" id="hd-type-status"><p></p></div>
		<div class="hd-message-form">
            {!! Form::open(['url' => route('session.message.text.store'), 'method' => 'POST', 'id' => 'hd-text-message-form', 'data-receiver' => $user->id, 'data-sender' => Auth::user()->username, 'data-path' => route('session.messages.load', Auth::user()->id) , 'data-url' => route('session.messages.load', $user->id), 'data-loader' => route('session.messages.load.all')]) !!}
                <div class="hd-image"><img src="{{ Auth::user()->getProfileImage() }}" alt="{{ Auth::user()->username }}" /></div>
                {!! Form::hidden('receiver', $user->id) !!}
                {!! Form::hidden('is_text_message', 0) !!}
                {!! Form::textarea('message', '', ['autocomplete' => 'off', 'placeholder' => 'Enter Short Message']) !!}
                <div class="hd-status" id="hd-open-message-menu" data-id="message-else"><span class="lnr lnr-cross"></span></div>
                <button type="submit" id="hd-message-submit" disabled="disabled"><span class="lnr lnr-arrow-right"></span></button>
                <div class="hd-menu hd-message-menu-else" id="hd-menu-message-else">
				    <ul>
                        <li>
                            <span class="lnr lnr-envelope"></span>
                            <a href="#hd-text-message-lg" id="hd-show-lg-message-model" data-toggle="modal" data-target="#hd-text-message-lg">Message</a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li>
                            <span class="lnr lnr-camera"></span>
                            <a href="#hd-images-message" id="hd-show-images-message-model" data-toggle="modal" data-target="#hd-images-message">Images</a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li>
                            <span class="lnr lnr-map-marker"></span>
                            <a href="#hd-location-message" id="hd-show-location-message-model" data-toggle="modal" data-target="#hd-location-message">Location</a>
                        </li>
                    </ul>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div id="hd-text-message-lg" class="modal zoom animate" data-backdrop="true">
        <div class="row-col h-v">
            <div class="row-cell v-m">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content hd-review-form">
                        {!! Form::open(['url' => route('session.message.text.store'), 'method' => 'POST', 'id' => 'hd-text-message-lg-form', 'data-receiver' => $user->id, 'data-sender' => Auth::user()->username, 'data-path' => route('session.messages.load', Auth::user()->id) , 'data-url' => route('session.messages.load', $user->id), 'data-loader' => route('session.messages.load.all')]) !!}
                            <div class="modal-header">
                                <h5 class="modal-title">Large Text Message</h5>
                            </div>
                            {!! Form::hidden('receiver', $user->id) !!}
                            {!! Form::hidden('is_text_message', true) !!}
                            <div style="margin:15px;">
                            {!! Form::textarea('message', '', ['autocomplete' => 'off', 'id' => 'hd-lg-text-message-input', 'placeholder' => 'Enter Text Message']) !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
                                <button type="submit" id="hd-submit" class="btn primary p-x-md">Send</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="hd-images-message" class="modal zoom animate" data-backdrop="true">
        <div class="row-col h-v">
            <div class="row-cell v-m">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content hd-review-form">
                        {!! Form::open(['url' => route('session.message.images.store'), 'enctype' => 'multipart/form-data', 'method' => 'POST', 'id' => 'hd-images-message-form', 'data-receiver' => $user->id, 'data-sender' => Auth::user()->username, 'data-path' => route('session.messages.load', Auth::user()->id) , 'data-url' => route('session.messages.load', $user->id), 'data-loader' => route('session.messages.load.all')]) !!}
                            <div class="modal-header">
                                <h5 class="modal-title">Send Images</h5>
                            </div>
                            <div class="hd-message-images-upload" style="margin:15px;">
                                {!! Form::hidden('receiver', $user->id) !!}
                                {!! Form::hidden('is_text_message', false) !!}
                                <p class="radius"><span class="lnr lnr-picture"></span> UPLOAD IMAGES TO SEND</p>
                                {!! Form::file('images[]', ['multiple' => true, 'id' => 'hd-message-images-in', 'accept' => 'image/png, image/jpg, image/jpeg', 'required' => 'required']) !!}
                                <div class="hd-image-preview">
                                    <div id="hd-image-preview" style="display:none;"></div>
                                </div>
                                <div class="progress" id="hd-files-upload-progress" style="display:none;">
                                    <div class="progress-bar" id="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemax="100" style="background:#02b875;font-size:13px;">0%</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
                                <button type="submit" id="hd-submit" class="btn primary p-x-md">Send</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="hd-location-message" class="modal zoom animate" data-backdrop="true">
        <div class="row-col h-v">
            <div class="row-cell v-m">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content hd-review-form">
                        {!! Form::open(['url' => route('session.message.location.store'), 'method' => 'POST', 'id' => 'hd-location-message-form', 'data-receiver' => $user->id, 'data-sender' => Auth::user()->username, 'data-path' => route('session.messages.load', Auth::user()->id) , 'data-url' => route('session.messages.load', $user->id), 'data-loader' => route('session.messages.load.all')]) !!}
                            <div class="modal-header">
                                <h5 class="modal-title">Send Location</h5>
                            </div>
                            <div class="hd-message-location">
                                {!! Form::hidden('receiver', $user->id) !!}
                                {!! Form::hidden('is_text_message', false) !!}
                                {!! Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Search Location', 'id' => 'hd-message-address']) !!}
                                {!! Form::hidden('longitude', '',['id' => 'hd-message-longitude']) !!}
                                {!! Form::hidden('latitude', '',['id' => 'hd-message-latitude']) !!}
                                <div class="hd-message-map" id="hd-message-map"></div> 
                            </div>                          
                            <div class="modal-footer">
                                <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
                                <button type="submit" id="hd-submit" class="btn primary p-x-md">Send</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    footer{display: none !important;} 
    body{background: #FFF !important;}
    .fr-placeholder{
        font-size: 14px !important;
        padding: 0.375rem 0.75rem !important;
    } 
    .fr-wrapper{
        padding: 0.375rem 0.75rem;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    </style>
    <script>loadHTMLAjax("hd-chat-messages-container", "{{ route('session.messages.load', $user->id) }}"); updateMessageScroll(); loadHTMLAjax("hd-messages-all", "{{ route('session.messages.load.all') }}");$("#hd-open-message-menu").showMenu();google.maps.event.addDomListener(window, 'load', InitializePlaces('hd-message-address'));</script>
</section>
@endsection