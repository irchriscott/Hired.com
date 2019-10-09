@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">Add Profile Images &amp; C.V</h1>
                    <p class="text-white">Images can be the one of your documents or where you are performing your the job.</p>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-add-new">
    <div class="hd-add-form" style="margin-bottom:30px;">
        <div class="hd-upload-files">
            {!! Form::open(['url' => route('user.profile.files.store', $profile->id), 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'hd-upload-profile-files', 'data-url' => route('user.profile.images.load', $profile->id)]) !!}
                {!! Form::file('images[]', ['id' => 'hd-in-profile-images', 'accept' => 'image/*', 'required' => 'required', 'multiple' => true]) !!}
                <p class="radius"><span class="lnr lnr-picture"></span> UPLOAD PROFILE IMAGES</p>
                <div class="hd-image-preview">
                    <div id="hd-load-img-ex"><div class="hd-spinner" style="display:block;"><span><i class="fa fa-spin fa-spinner"></i></span></div></div>
                    <div id="hd-image-preview" style="display:none;"></div>
                </div>
                {!! Form::file('cv', ['id' => 'hd-in-cv', 'accept' => '.pdf, .docx, .doc']) !!}
                <p class="radius"><span class="lnr lnr-file-add"></span> UPLOAD YOUR CURRICILUM VITAE</p>
                <span style="text-align:center;display:block;margin-top:-10px;" id="hd-cv-name">{{ $profile->cv_document }}</span>
                <div style="opacity:0;">Hired.com</div>
                <div class="progress" id="hd-files-upload-progress" style="margin-bottom:40px;display:none;">
                    <div class="progress-bar" id="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemax="100" style="background:#02b875;font-size:13px;">0%</div>
                </div>
                <div class="hd-links">
                    <button type="submit" class="genric-btn primary radius">SUBMIT</button>
                    <a href="{{ route('user.profile.show', [$profile->id, $profile->uuid]) }}" class="genric-btn info-border radius">VIEW PROFILE</a>
                </div>
            {!! Form::close() !!}
        </div>
        <script>loadHTMLAjax("hd-load-img-ex", "{{ route('user.profile.images.load', $profile->id) }}")</script>
    </div>
</section>
@endsection