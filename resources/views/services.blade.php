@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">Services</h1>
                    <p class="text-white">View all posted services and filter them</p>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-jb-container">
    <div class="hd-filter">
        <input type="search" id="hd-filter-data-input" data-url="{{ route('job.services') }}?type=all" data-type="all" class="form-control" placeholder="Search For Services Here At Hired.com"/>
        <div class="hd-filter-categories" id="hd-filter-categories">
            <div class="hd-arrow-left"><button type="button" id="hd-left-btn"><span class="lnr lnr-chevron-left"></span></button></div>
            <div class="hd-arrow-right"><button type="button" id="hd-right-btn"><span class="lnr lnr-chevron-right"></span></button></div>
            <div class="hd-categories" id="hd-categories">
                <ul>
                    <li class="active" data-url="{{ route('job.services') }}?type=all" data-type="all">
                        <div class="hd-image"><p><i class="fa fa-asterisk"></i></p></div>
                        <div class="hd-text"><p>All</p></div>
                    </li>
                    @if(count($categories) > 0)
                        @foreach($categories as $category)
                            <li data-type="{{ $category->id }}" data-url="{{ route('job.services') }}?type={{ $category->id }}">
                                <div class="hd-image"><img src="{{ $category->getCategoryImage() }}" /></div>
                                <div class="hd-text"><p>{{ $category->name }}</p></div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <hr/>
    <div class="hd-jb-data">
        <div id="hd-jb-container-data">
            <div class="hd-spinner" style="display:block; margin:50px 0;"><span><i class="fa fa-spin fa-spinner"></i></span></div>
            <script>loadHTMLAjax("hd-jb-container-data", "{{ route('job.services') }}?type=all");</script>
        </div>
    </div>
</section>
@endsection