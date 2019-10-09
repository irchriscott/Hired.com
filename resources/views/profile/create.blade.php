@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">Add New Job Profile</h1>
                    <p class="text-white">A job profile defines a kind a job you can do or a service you can give to someone</p>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-add-new">
    <div class="hd-add-form" style="margin-bottom:30px;">
        {!! Form::open(['url' => route('user.profile.store'), 'method' => 'POST']) !!}
            {!! Form::text('title', '', ['class' => 'form-control hd-form-text', 'placeholder' => 'Title Your Job Profile', 'required' => 'required', 'style' => 'font-weight:bold;font-size:35px;', 'autocomplete' => 'off']) !!}
            {!! Form::textarea('about', '', ['class' => 'form-control hd-form-text', 'placeholder' => 'About The Job Profile', 'required' => 'required', 'rows' => '1', 'id' => 'hd-profile-about']) !!}
            <br/>
            {!! Form::textarea('description', '', ['class' => 'form-control hd-form-textarea', 'placeholder' => 'Describe Your Job Profile', 'required' => 'required' , 'id' => 'hd-profile-description']) !!}
            <button type="submit" class="genric-btn primary radius">
                {{ __('Save') }}
            </button>
            <a class="genric-btn danger-border radius" href="{{ route('session.profiles') }}">
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
<script src="{{ asset('js/autosize.min.js') }}"></script>
<script type="text/javascript">autosize(document.getElementById('hd-profile-about'))</script>
@endsection