@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover">
			<div class="col-lg-10">
				<div class="generic-banner-content">
                    <h2 class="text-white">My Favourite Quote</h2>
                    @if($user->data)
                        <p class="text-white"><< {{ $user->data->quote}} >></p>
                    @endif
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-user-menu">
    @include('user.pimage')
    <div class="hd-menu-user nav-active-border">
        <div class="hd-profile-user-menu">
            <div class="hd-image"><img src="{{ $user->getProfileImage() }}" alt="{{ $user->username }}"></div>
            <div class="hd-about"><h5>{{ $user->name }}</h5><p><span>@</span>{{ $user->username }}</p></div>
        </div>
        <ul class="nav nav-md">
            <li class="nav-item inline">
                <a class="nav-link" href="{{ route('user.services', $user->username) }}">
                    <span class="text-md">Services Jobs</span>
                    <small class="block text-muted hidden-xs">Short Time Jobs</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link" href="{{ route('user.jobs', $user->username) }}">
                    <span class="text-md">Jobs Posted</span>
                    <small class="block text-muted hidden-xs">Full Time or Long Term Jobs</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link" href="{{ route('user.profiles', $user->username) }}">
                    <span class="text-md">Profiles</span>
                    <small class="block text-muted hidden-xs">Different Types of Jobs</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link" href="{{ route('user.blogs', $user->username) }}">
                    <span class="text-md">Blogs</span>
                    <small class="block text-muted hidden-xs">User's Blogs</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link active" href="{{ route('user.about', $user->username) }}">
                    <span class="text-md">About</span>
                    <small class="block text-muted hidden-xs">User's Identity &amp; Addresses</small>
                </a>
            </li>
        </ul>
        <div class="hd-data-menu">
            <span class="hd-data-menu-btn" data-id="profile"><span class="lnr lnr-chevron-down"></span></span>
            <div class="hd-menu hd-profile-menu" id="hd-menu-profile">
				<ul>
                    @guest
                    @else
                        <li>
                            <span class="lnr lnr-envelope"></span>
                            <a href="{{ route('session.messages.user', $user->username) }}">Message</a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li>
                            <span class="lnr lnr-cog"></span>
                            <a href="#">Report</a>
                        </li>
                    @endguest
				</ul>
			</div>
        </div>
    </div>
    <div class="row-col row hd-row-col">
        @include('user.info')
        <div class="b-t col-lg-6 b-r hd-content">
            <div class="hd-content">
                <div class="box-body hd-padding">
                    <h2>Identity</h2>
                    <hr><br/>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Name</div>
                        <div class="col-sm-9"><p>{{ $user->name }}</p></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Username</div>
                        <div class="col-sm-9"><p>{{ $user->username }}</p></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Gender</div>
                        <div class="col-sm-9"><p>{{ $user->gender }}</p></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Country</div>
                        <div class="col-sm-9"><p>{{ $user->getCountry() }}</p></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Town / City</div>
                        <div class="col-sm-9"><p>{{ $user->town }}</p></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Account Type</div>
                        <div class="col-sm-9">{{ $user->type }}</div>
                    </div>
                    <hr>
                    <h2>Contacts</h2>
                    <hr><br/>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Email Address</div>
                        <div class="col-sm-9"><p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Phone Number</div>
                        <div class="col-sm-9"><p>{{ $user->phone_number }}</p></div>
                    </div>
                    <hr>
                    <h2>About You (Job)</h2>
                    <hr><br/>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Job Status</div>
                        <div class="col-sm-9">@if($user->data){{ $user->data->getJobStatus() }}@else - @endif</div>
                    </div>
                    @if($user->type == 'User')
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Current Company (if status is Employed)</div>
                            <div class="col-sm-9"><p>@if($user->data){{ $user->data->company }}@else - @endif</p></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Current Job (if status is Employed)</div>
                            <div class="col-sm-9"><p>@if($user->data){{ $user->data->current_job }}@else - @endif</p></div>
                        </div>
                    @else
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Number of Employees</div>
                            <div class="col-sm-9"><p>@if($user->data){{ $user->data->employees }} Employees @else - @endif</p></div>
                        </div>
                    @endif
                    <hr>
                    <h2>Social Network Links</h2>
                    <hr><br/>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Facebook</div>
                        <div class="col-sm-9"><p>@if($user->data)<a href="@if($user->data->facebook) {{ $user->data->facebook }} @else # @endif">{{ $user->name }}</a> @else - @endif</p></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Twitter</div>
                        <div class="col-sm-9"><p>@if($user->data)<a href="@if($user->data->facebook) {{ $user->data->twitter }} @else # @endif">{{ $user->username }}</a> @else - @endif</p></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">LinkedIn</div>
                        <div class="col-sm-9"><p>@if($user->data)<a href="@if($user->data->facebook) {{ $user->data->linked_in }} @else # @endif">{{ $user->username }}</a> @else - @endif</p></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">GitHub(For Developpers and Programmers)</div>
                        <div class="col-sm-9"><p>@if($user->data)<a href="@if($user->data->github) {{ $user->data->github }} @else # @endif">{{ $user->username }}</a> @else - @endif</p></div>
                    </div>     
                    <hr>
                    <h2>Biography</h2>
                    <hr><br/>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Bio</div>
                        <div class="col-sm-9"><p>@if($data){{ $data->about }}@else - @endif</p></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 form-control-label text-muted">Quote</div>
                        <div class="col-sm-9"><p>@if($data){{ $data->quote }}@else - @endif</p></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 w-xxl w-auto-md">
            <div class="box-body" style="padding-top:0 !important;">
                <div class="hd-content">
                    <h4>Users &amp; Companies</h4>
                    @if(count($users) > 0)
                        <ul>
                            @foreach($users as $user)
                                <li>
                                    <div class="hd-image"><img src="{{ $user->getProfileImage() }}" alt="{{ $user->username }}"></div>
                                    <div class="hd-info">
                                        <a href="{{ route('user.about', $user->username) }}"><h4>{{ $user->name }} <span>@</span><span>{{ $user->username }}</span></h4></a>
                                        <div class="meta-bottom d-flex justify-content-between hd-jb-text">
                                            <p><a href="{{ route('user.profiles', $user->username) }}"><span class="lnr lnr-user"></span> {{ count($user->profiles) }} Profiles</a></p>
                                            <p><a href="{{ route('user.jobs', $user->username) }}"><span class="lnr lnr-briefcase"></span> {{ count($user->jobs) }} Jobs</a></p>
                                            <p><a href="{{ route('user.services', $user->username) }}"><span class="lnr lnr-layers"></span> {{ count($user->services) }} Services</a></p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="hd-error">NO USER</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection