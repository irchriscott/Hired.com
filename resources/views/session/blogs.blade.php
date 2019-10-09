@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h2 class="text-white">My Favourite Quote</h2>
                    @if(Auth::user()->data)
                        <p class="text-white"><< {{ Auth::user()->data->quote}} >></p>
                    @endif
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-user-menu">
    @include('session.pimage')
    <div class="hd-menu-user nav-active-border">
        <div class="hd-profile-user-menu">
            <div class="hd-image"><img src="{{ Auth::user()->getProfileImage() }}" alt="{{ Auth::user()->username }}"></div>
            <div class="hd-about"><h5>{{ Auth::user()->name }}</h5><p><span>@</span>{{ Auth::user()->username }}</p></div>
        </div>
        <ul class="nav nav-md">
            <li class="nav-item inline">
                <a class="nav-link" href="{{ route('session.services') }}">
                    <span class="text-md">Services Jobs</span>
                    <small class="block text-muted hidden-xs">Short Time Jobs</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link" href="{{ route('session.jobs') }}">
                    <span class="text-md">Jobs Posted</span>
                    <small class="block text-muted hidden-xs">Full Time or Long Term Jobs</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link" href="{{ route('session.profiles') }}">
                    <span class="text-md">Profiles</span>
                    <small class="block text-muted hidden-xs">Different Types of Jobs</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link active" href="{{ route('session.blogs') }}">
                    <span class="text-md">Blogs</span>
                    <small class="block text-muted hidden-xs">Session's Blogs</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link" href="{{ route('session.about') }}">
                    <span class="text-md">About</span>
                    <small class="block text-muted hidden-xs">User's Identity &amp; Addresses</small>
                </a>
            </li>
        </ul>
        <a href="{{ route('user.blog.create') }}" class="hd-btn-right genric-btn primary radius">Add New Blog</span></a>
    </div>
    <div class="row-col row hd-row-col">
        @include('session.info')
        <div class="tab-content clear col-lg-6 no-border-md">
            <div class="tab-pane active">
                <div class="box-body hd-content-row">
                    <h1>Blogs</h1>
                    <hr/>
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
        <div class="col-lg-3 w-xxl w-auto-md">
            <div class="box-body" style="padding-top:0 !important;">
                <div class="hd-content">
                    <h4>Profiles In Categories</h4>
                    @if(count($categories) > 0)
                        <ul>
                            @foreach($categories as $category)
                                <li>
                                    <div class="hd-image"><img src="{{ $category->getCategoryImage() }}"></div>
                                    <div class="hd-info">
                                        <a href="#"><h4>{{ $category->name }}</span></h4></a>
                                        <div class="meta-bottom d-flex justify-content-between hd-jb-text">
                                            <p><span class="lnr lnr-user"></span> {{ $category->profilesCount() }} Profiles</p>
                                            <p><span class="lnr lnr-briefcase"></span> {{ $category->jobsCount() }} Jobs</p>
                                            <p><span class="lnr lnr-layers"></span> {{ count($category->subcategories) }} Subcats</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="hd-error">NO CATEGORY</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection