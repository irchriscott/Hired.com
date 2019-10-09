@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">{!! $subcategory->getIcon() !!}{{ $subcategory->name }}</h1>
                    <p class="text-white">{{ $subcategory->description }}</p>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-jb-container">
    <div class="hd-filter">
        <h2>{{ $subcategory->name }}</h2>
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
                    @if(count($profiles) > 0)
                        @foreach($profiles as $profile)
                            <div class="row">
                                <div class="col-md-4 hd-image">
                                    <img style="margin-left:4px;" src="{{ $profile->images[0]->getImagePath() }}" alt="{{ $profile->title }}" class="img-fluid">
                                </div>
                                <div class="col-md-8 mt-sm-20">
                                    <a href="{{ route('user.profile.show', [$profile->id, $profile->uuid]) }}"><h2>{{ $profile->title }}</h2></a>
                                    <p>{{ $profile->about }}</p>
                                    <div class="hd-categories-badges hd-badge-small" style="margin-top:-8px; margin-bottom:6px;" id="hd-form-badges">
                                        @if(count($profile->preferences) > 0)
                                            @foreach($profile->preferences as $pref)
                                                <div class="hd-badge">
                                                    <div class="hd-badge-content">
                                                        <span class="hd-b-text"><a href="{{ route('category.subcategory.data.get', [$pref->category->id, $pref->subcategory->id]) }}">{{ $pref->subcategory->name }}</a></span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="hd-error">NO PREFERENCES. PLEASE ADD SOME</p>
                                        @endif
                                    </div>
                                    <div class="hd-description-user-small">
                                        <img src="{{ $profile->user->getProfileImage() }}" alt="{{ $profile->user->username }}" />
                                        <p class="hd-user-name"><a href="{{ route('user.about', $profile->user->username) }}" target="_blank">{{ $profile->user->name }} <span><span>@</span>{{ $profile->user->username }}</span></a></p>
                                        
                                    </div>
                                </div>
                            </div>
                            <hr/>
                        @endforeach
                    @else
                        <p class="hd-error" style="margin:30px 0;">NO POSTED PROFILE YET</p>
                    @endif
                </div>
            </div>
            <div class="tab-pane" id="jobs">
                <div id="hd-container-data-jobs">
                    @if(count($jobs) > 0)
                        @foreach($jobs as $job)
                            <div class="row" style="margin-left:-12px;">
                                <div class="col-md-4 hd-image">
                                    <img src="{{ $job->images[0]->getImagePath() }}" alt="{{ $job->title }}" class="img-fluid">
                                </div>
                                <div class="col-md-8 mt-sm-20">
                                    <a href="{{ route('job.show', [$job->id, $job->uuid]) }}"><h2>{{ $job->title }}</h2></a>
                                    <h5 style="margin-top:-3px;">{{ $job->position }}</h5>
                                    <div class="meta-bottom d-flex justify-content-between" style="margin-top:-5px;">
                                        <p><strong>Salary : </strong> {{ $job->getSalary() }}</p>
                                        <p><strong>Duration : </strong> {{ $job->getDuration() }}</p>
                                    </div>
                                    <div class="hd-categories-badges hd-badge-small" id="hd-form-badges">
                                        @if(count($job->preferences) > 0)
                                            @foreach($job->preferences as $pref)
                                                <div class="hd-badge">
                                                    <div class="hd-badge-content">
                                                        <span class="hd-b-text"><a href="{{ route('category.subcategory.data.get', [$pref->category->id, $pref->subcategory->id]) }}">{{ $pref->subcategory->name }}</a></span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="hd-error">NO PREFERENCES. PLEASE ADD SOME</p>
                                        @endif
                                    </div>
                                    <div class="meta-bottom d-flex justify-content-between hd-jb-text">
                                        <p><span class="lnr lnr-heart"></span> {{ $job->likesCount() }} Likes</p>
                                        <p><span class="lnr lnr-briefcase"></span> {{ $job->suggestionsCount() }} Suggestions</p>
                                        <p><span class="lnr lnr-bubble"></span> {{ $job->commentsCount() }} Comments</p>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                        @endforeach
                    @else
                        <p class="hd-error" style="margin:30px 0;">NO POSTED JOB YET</p>
                    @endif
                </div>
            </div>
            <div class="tab-pane" id="services">
                <div id="hd-container-data-services">
                    @if(count($services) > 0)
                        @foreach($services as $job)
                            <div class="row" style="margin-left:-12px;">
                                <div class="col-md-4 hd-image">
                                    <img src="{{ $job->images[0]->getImagePath() }}" alt="{{ $job->title }}" class="img-fluid">
                                </div>
                                <div class="col-md-8 mt-sm-20">
                                    <a href="{{ route('job.show', [$job->id, $job->uuid]) }}"><h2>{{ $job->title }}</h2></a>
                                    <h5 style="margin-top:-3px;">{{ $job->position }}</h5>
                                    <div class="meta-bottom d-flex justify-content-between" style="margin-top:-5px;">
                                        <p><strong>Salary : </strong> {{ $job->getSalary() }}</p>
                                        <p><strong>Duration : </strong> {{ $job->getDuration() }}</p>
                                    </div>
                                    <div class="hd-categories-badges hd-badge-small" id="hd-form-badges">
                                        @if(count($job->preferences) > 0)
                                            @foreach($job->preferences as $pref)
                                                <div class="hd-badge">
                                                    <div class="hd-badge-content">
                                                        <span class="hd-b-text"><a href="{{ route('category.subcategory.data.get', [$pref->category->id, $pref->subcategory->id]) }}">{{ $pref->subcategory->name }}</a></span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="hd-error">NO PREFERENCES. PLEASE ADD SOME</p>
                                        @endif
                                    </div>
                                    <div class="meta-bottom d-flex justify-content-between hd-jb-text">
                                        <p><span class="lnr lnr-heart"></span> {{ $job->likesCount() }} Likes</p>
                                        <p><span class="lnr lnr-briefcase"></span> {{ $job->suggestionsCount() }} Suggestions</p>
                                        <p><span class="lnr lnr-bubble"></span> {{ $job->commentsCount() }} Comments</p>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                        @endforeach
                    @else
                        <p class="hd-error" style="margin:30px 0;">NO POSTED SERVICE YET</p>
                    @endif
                </div>
            </div>
            <div class="tab-pane" id="blogs">
                <div id="hd-container-data-blogs">
                    @if(count($blogs) > 0)
                        @foreach($blogs as $blog)
                            <div class="row" style="margin-left:-12px;">
                                <div class="col-md-2">
                                    <img src="{{ $blog->user->getProfileImage() }}" alt="{{ $blog->user->username }}" class="img-fluid">
                                </div>
                                <div class="col-md-10 mt-sm-20">
                                    <a href="{{ route('user.blog.show', [$blog->id, $blog->uuid]) }}"><h2>{{ $blog->title }}</h2></a>
                                    <div class="hd-categories-badges hd-badge-small" style="margin-top:-3px; margin-bottom:10px;">
                                        @if(count($blog->preferences) > 0)
                                            @foreach($blog->preferences as $pref)
                                                <div class="hd-badge">
                                                    <div class="hd-badge-content">
                                                        <span class="hd-b-text"><a href="{{ route('category.subcategory.data.get', [$pref->category->id, $pref->subcategory->id]) }}">{{ $pref->subcategory->name }}</a></span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="hd-error">NO PREFERENCES. PLEASE ADD SOME</p>
                                        @endif
                                    </div>
                                    <div class="meta-bottom d-flex justify-content-between hd-jb-text">
                                        <p>By <a href="{{ route('user.blogs', $blog->user->username) }}">{{ $blog->user->name }}</a> <span style="margin:0 10px;">-</span> <span id="hd-blog-date-{{ $blog->id }}" data-date="{{ $blog->created_at }}"></span></p>
                                        <p><span class="lnr lnr-heart"></span> {{ $blog->likesCount() }} Likes</p>
                                        <p><span class="lnr lnr-bubble"></span> {{ $blog->responsesCount() }} Responses</p>
                                    </div>
                                </div>
                            </div>
                            <script>$("#hd-blog-date-{{ $blog->id }}").setDate();</script>
                            <hr/>
                        @endforeach
                    @else
                        <p class="hd-error" style="margin:30px 0;">NO POSTED BLOG YET</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>h1 i{color: #FFFFFF; margin-right: 8px;}</style>
</section>
@endsection