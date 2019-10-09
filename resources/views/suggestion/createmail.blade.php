@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">Send Email</h1>
                    <p class="text-white">This email will be sent to all the users who have suggested to this {{ $job->job_type }}</p>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-add-new">
    <div class="hd-add-form hd-mail-form" style="margin-bottom:30px;">
        {!! Form::open(['url' => route('job.suggestions.email.store', $job->id), 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            {!! Form::text('title', '', ['class' => 'form-control hd-form-text', 'placeholder' => 'Enter Email Title', 'required' => 'required', 'style' => 'font-weight:bold;font-size:22px;', 'autocomplete' => 'off']) !!}
            <br/>
            {!! Form::textarea('message', '', ['class' => 'form-control hd-form-textarea', 'placeholder' => 'Enter Email Message', 'required' => 'required' , 'id' => 'hd-email-text', 'autocomplete' => 'off']) !!}
            {!! Form::file('file') !!}
            <p class="radius"><span class="lnr lnr-file-add"></span> UPLOAD ATTACHMENT</p>
            <button type="submit" class="genric-btn primary radius">
                {{ __('Send') }}
            </button>
            <a class="genric-btn danger-border radius" href="{{ route('job.suggestions.manage.all', [$job->id, $job->uuid]) }}">
                {{ __('Cancel') }}
            </a>
        {!! Form::close() !!}
    </div>
</section>
<style type="text/css">
    .fr-placeholder{
        padding: 1rem !important;
    } 
    .fr-wrapper{
        padding: 1rem;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        margin-top: -20px;
    }
</style>
@endsection