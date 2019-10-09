@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">Add Profile Preferences</h1>
                    <p class="text-white">These are categories and subcategories that define your job profile. They will be usefull in search mode</p>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-add-new">
    <div class="hd-add-form" style="margin-bottom:30px;">
        <div style="width:90%; margin:auto;" id="hd-profile-preferences">
            <div class="hd-spinner" style="display:block;"><span><i class="fa fa-spin fa-spinner"></i></span></div>
            <script>loadHTMLAjax('hd-profile-preferences', "{{ route('user.profile.peferences.load', $profile->id) }}");</script>
        </div>
        <div class="text-center">
            <button class="genric-btn primary e-large" data-toggle="modal" data-target="#hd-add-peferences" data-ui-toggle-class="zoom" data-ui-target="#animate">ADD PREFERENCE</button>
            <br/>
            <a href="{{ route('user.profile.files.create', [$profile->id, $profile->uuid]) }}" id="hd-profile-add-files-lnk" style="margin-top:15px;" class="genric-btn default-border radius">ADD IMAGES AND C.V</a>
        </div>
    </div>
</section>
<div id="hd-add-peferences" class="modal zoom animate" data-backdrop="true">
    <div class="row-col h-v">
        <div class="row-cell v-m">
            <div class="modal-dialog">
                <div class="modal-content" id="hd-preferences-body" url-check="{{ route('user.profile.peferences.check', $profile->id) }}" url-submit="{{ route('user.profile.peferences.store', $profile->id) }}" url-load="{{ route('user.profile.peferences.load', $profile->id) }}" data-id="{{$profile->id}}">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Profile Peferences</h5>
                    </div>
                    <div class="modal-body p-lg">
                        {!! Form::open(['url' => '#', 'method' => 'POST']) !!}
                            {!! Form::text('category', '', ['id' => 'hd-add-preferences', 'class' => 'hd-input-modal', 'placeholder' => 'Search Category Preference', 'style' => 'margin-top:10px;', 'autocomplete' => 'off']) !!}
                            <div class="hd-categories-container" id="hd-categories-container"><div class="hd-spinner" id="hd-spinner"><i class="fa fa-spin fa-spinner"></i></div><ul></ul><a href="#" class="hd-collapse" id="hd-collapse-categories">Collapse</a></div>
                            <div class="hd-categories-badges" id="hd-form-badges" style="margin-top:10px; text-align:center;"></div>
                            {!! Form::text('subcategory', '', ['id' => 'hd-add-sub-preferences', 'class' => 'hd-input-modal', 'placeholder' => 'Search Subcategory Preference', 'style' => 'margin-top:10px; display:none;', 'disabled' => 'disabled', 'autocomplete' => 'off']) !!}
                            <div class="hd-categories-container" id="hd-subcategories-container"><div class="hd-spinner" id="hd-spinner-else"><i class="fa fa-spin fa-spinner"></i></div><ul></ul><a href="#" class="hd-collapse" id="hd-collapse-subcategories">Collapse</a></div>
                        {!! Form::close() !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="hd-close-add-preferences" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
                        <button type="button" id="hd-save-prefernces" class="btn primary p-x-md">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection