@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">Add Job Or Service Images</h1>
                    <p class="text-white">Images can be the one of the working place or may be of the job itself</p>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-add-new">
    <div class="hd-add-form" style="margin-bottom:30px;">
        <div class="hd-upload-files">
            {!! Form::open(['url' => route('job.images.store', $job->id), 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'hd-upload-profile-files', 'data-url' => route('job.images.load', $job->id)]) !!}
                {!! Form::file('images[]', ['id' => 'hd-in-profile-images', 'accept' => 'image/*', 'required' => 'required', 'multiple' => true]) !!}
                <p class="radius"><span class="lnr lnr-picture"></span> UPLOAD PROFILE IMAGES</p>
                <div class="hd-image-preview">
                    <div id="hd-load-img-ex"><div class="hd-spinner" style="display:block;"><span><i class="fa fa-spin fa-spinner"></i></span></div></div>
                    <div id="hd-image-preview" style="display:none;"></div>
                </div>
                <div class="progress" id="hd-files-upload-progress" style="margin-bottom:40px;display:none;">
                    <div class="progress-bar" id="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemax="100" style="background:#02b875;font-size:13px;">0%</div>
                </div>
                <div class="hd-links">
                    <button type="submit" class="genric-btn primary radius">SUBMIT</button>
                    <a href="{{ route('job.show', [$job->id, $job->uuid]) }}" class="genric-btn info-border radius">VIEW PROFILE</a>
                </div>
            {!! Form::close() !!}
        </div>
        <script>loadHTMLAjax("hd-load-img-ex", "{{ route('job.images.load', $job->id) }}")</script>
    </div>
</section>
@endsection