@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">{{ $category->name }}</h1>
                    <p class="text-white">{{ $category->description }}</p>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-jb-container">
    <div class="hd-filter">
        <h2>{{ $category->name }}</h2>
        <div class="hd-filter-categories" id="hd-filter-categories">
            <div class="hd-arrow-left"><button type="button" id="hd-left-btn"><span class="lnr lnr-chevron-left"></span></button></div>
            <div class="hd-arrow-right"><button type="button" id="hd-right-btn"><span class="lnr lnr-chevron-right"></span></button></div>
            <div class="hd-categories" id="hd-subcategories">
                <ul>
                    <li class="active" data-profiles="{{ route('category.subcategories.data.load', $category->id) }}?type=p&subcat=all" data-jobs="{{ route('category.subcategories.data.load', $category->id) }}?type=j&subcat=all" data-services="{{ route('category.subcategories.data.load', $category->id) }}?type=s&subcat=all" data-blogs="{{ route('category.subcategories.data.load', $category->id) }}?type=s&subcat=all" data-type="all">
                        <div class="hd-image"><p><i class="fa fa-asterisk"></i></p></div>
                        <div class="hd-text"><p>All</p></div>
                    </li>
                    @if(count($subcategories) > 0)
                        @foreach($subcategories as $subcat)
                            <li data-type="{{ $subcat->id }}" data-profiles="{{ route('category.subcategories.data.load', $category->id) }}?type=p&subcat={{ $subcat->id }}" data-jobs="{{ route('category.subcategories.data.load', $category->id) }}?type=j&subcat={{ $subcat->id }}" data-services="{{ route('category.subcategories.data.load', $category->id) }}?type=s&subcat={{ $subcat->id }}" data-blogs="{{ route('category.subcategories.data.load', $category->id) }}?type=b&subcat={{ $subcat->id }}">
                                <div class="hd-image"><p>{!! $subcat->getIcon() !!}</p></div>
                                <div class="hd-text"><p>{{ $subcat->name }}</p></div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="hd-jb-menu nav-active-border">
        <ul class="nav nav-md">
            <li class="nav-item inline">
                <a class="nav-link active" href="#" data-toggle="tab" data-target="#profiles">
                    <span class="text-md">Profiles</span>
                    <small class="block text-muted hidden-xs">User profiles in this subcat</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link" href="#" data-toggle="tab" data-target="#jobs">
                    <span class="text-md">Jobs</span>
                    <small class="block text-muted hidden-xs">Jobs in this subcat</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link" href="#" data-toggle="tab" data-target="#services">
                    <span class="text-md">Services</span>
                    <small class="block text-muted hidden-xs">Services in this subcat</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link" href="#" data-toggle="tab" data-target="#blogs">
                    <span class="text-md">Blogs</span>
                    <small class="block text-muted hidden-xs">Blogs in this subcat</small>
                </a>
            </li>
        </ul>
    </div>
    <div class="hd-jb-data">
        <div class="tab-content no-border-md" style="margin-top:5px;">
            <div class="tab-pane active" id="profiles">
                <div id="hd-container-data-profiles">
                    <div class="hd-spinner" style="display:block; margin:50px 0;"><span><i class="fa fa-spin fa-spinner"></i></span></div>
                    <script>loadHTMLAjax("hd-container-data-profiles", "{{ route('category.subcategories.data.load', $category->id) }}?type=p&subcat=all");</script>
                </div>
            </div>
            <div class="tab-pane" id="jobs">
                <div id="hd-container-data-jobs">
                    <div class="hd-spinner" style="display:block; margin:50px 0;"><span><i class="fa fa-spin fa-spinner"></i></span></div>
                    <script>loadHTMLAjax("hd-container-data-jobs", "{{ route('category.subcategories.data.load', $category->id) }}?type=j&subcat=all");</script>
                </div>
            </div>
            <div class="tab-pane" id="services">
                <div id="hd-container-data-services">
                    <div class="hd-spinner" style="display:block; margin:50px 0;"><span><i class="fa fa-spin fa-spinner"></i></span></div>
                    <script>loadHTMLAjax("hd-container-data-services", "{{ route('category.subcategories.data.load', $category->id) }}?type=s&subcat=all");</script>
                </div>
            </div>
            <div class="tab-pane" id="blogs">
                <div id="hd-container-data-blogs">
                    <div class="hd-spinner" style="display:block; margin:50px 0;"><span><i class="fa fa-spin fa-spinner"></i></span></div>
                    <script>loadHTMLAjax("hd-container-data-blogs", "{{ route('category.subcategories.data.load', $category->id) }}?type=b&subcat=all");</script>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection