@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">Categories | Job Industries</h1>
                    <p class="text-white">See industry in which you can get available jobs on Hired.com</p>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-jb-container">
    <h2>Categories</h2>
    <hr/>
    @if(count($categories) > 0)
        @foreach($categories as $category)
            <div class="row" style="margin-left:-12px;">
                <div class="col-md-2">
                    <img src="{{ $category->getCategoryImage() }}" class="img-fluid">
                </div>
                <div class="col-md-10 mt-sm-20">
                    <a href="{{ route('category.subcategories', $category->id) }}"><h2>{{ $category->name }}</h2></a>
                    <p style="margin-top:-3px;">{{ $category->description }}</p>
                    <div class="meta-bottom d-flex justify-content-between hd-jb-text">
                        <p><span class="lnr lnr-user"></span> {{ $category->profilesCount() }} Profiles</p>
                        <p><span class="lnr lnr-briefcase"></span> {{ $category->jobsCount() }} Jobs</p>
                        <p><span class="lnr lnr-layers"></span> {{ count($category->subcategories) }} Subcategories</p>
                    </div>
                </div>
            </div>
            <hr/>
        @endforeach
    @else
        <p class="hd-error" style="margin:30px 0;">NO POSTED JOB YET</p>
    @endif
</section>
@endsection