@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">Add New Blog</h1>
                    <p class="text-white">Inspire people, tell the about your expirience, help them to excel in their jobs</p>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-add-new">
    <div class="hd-add-form" style="margin-bottom:30px;">
        {!! Form::open(['url' => route('user.blog.store'), 'method' => 'POST']) !!}
            {!! Form::text('title', '', ['class' => 'form-control hd-form-text', 'placeholder' => 'Title Your Blog', 'required' => 'required', 'style' => 'font-weight:bold;font-size:35px;', 'autocomplete' => 'off']) !!}
            <br/>
            {!! Form::textarea('blog', '', ['class' => 'form-control hd-form-textarea', 'placeholder' => 'Enter The Content Of Your Blog', 'required' => 'required' , 'id' => 'hd-blog-description']) !!}
            <button type="submit" class="genric-btn primary radius">
                {{ __('Save') }}
            </button>
            <a class="genric-btn danger-border radius" href="{{ route('session.blogs') }}">
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
        min-height: 550px !important;
    }
</style>
@endsection