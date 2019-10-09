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
                <a class="nav-link" href="{{ route('session.blogs') }}">
                    <span class="text-md">Blogs</span>
                    <small class="block text-muted hidden-xs">Session's Blogs</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link active" href="{{ route('session.about') }}">
                    <span class="text-md">About</span>
                    <small class="block text-muted hidden-xs">User's Identity &amp; Addresses</small>
                </a>
            </li>
        </ul>
    </div>
    <div class="row-col row hd-row-col">
        @include('session.info')
        <div class="b-t col-lg-6 b-r hd-content">
            <div class="hd-content">
                <div class="box-body hd-padding">
                    <h2>Identity</h2>
                    <hr><br/>
                    {!! Form::open(['url' => route('session.update.identity'), 'method' => 'POST']) !!}
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Name</div>
                            <div class="col-sm-9">{!! Form::text('name', Auth::user()->name, ['class' => 'form-control']) !!}</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Username</div>
                            <div class="col-sm-9">{!! Form::text('username', Auth::user()->username, ['class' => 'form-control']) !!}</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Gender</div>
                            <div class="col-sm-9">
                                <select class="nice-select wide" name="gender" id="gender" value="{{ Auth::user()->gender }}" >
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Country</div>
                            <div class="col-sm-9">
                                <select name="country" id="country" class="nice-select wide">
                                    @foreach($countries as $country)
                                        @if($country->cca2 == Auth::user()->country )
                                            <option selected value="{{$country->cca2}}">{{$country->name->common}}</option>
                                        @else
                                            <option value="{{$country->cca2}}">{{$country->name->common}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Town / City</div>
                            <div class="col-sm-9">{!! Form::text('town', Auth::user()->town, ['class' => 'form-control']) !!}</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Account Type</div>
                            <div class="col-sm-9">
                                <select class="nice-select wide" name="type" value="{{ Auth::user()->type }}" >
                                    <option value="User">User</option>
                                    <option value="Company">Company</option>
                                </select>
                            </div>
                        </div>
                        {!! Form::hidden('_method', 'PATCH') !!}
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="nw-btn primary-btn genric-btn radius">Save <span class="lnr lnr-arrow-right"></span></button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <hr>
                    <h2>Contacts</h2>
                    <hr><br/>
                    {!! Form::open(['url' => route('session.update.contacts'), 'method' => 'POST']) !!}
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Email Address</div>
                            <div class="col-sm-9">{!! Form::email('email', Auth::user()->email, ['class' => 'form-control'])!!}</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Phone Number</div>
                            <div class="col-sm-9">{!! Form::number('phone_number', Auth::user()->phone_number, ['class' => 'form-control', 'placeholder' => '256777777777']) !!}</div>
                        </div>
                        {!! Form::hidden('_method', 'PATCH') !!}
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="nw-btn primary-btn genric-btn radius">Save <span class="lnr lnr-arrow-right"></span></button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <hr>
                    <h2>About You (Job)</h2>
                    <hr><br/>
                    {!! Form::open(['url' => route('session.update.about'), 'method' => 'POST']) !!}
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Job Status</div>
                            <div class="col-sm-9">
                                <select class="nice-select wide" name="job_status" id="gender">
                                    @for($i = 0; $i < count($statuses); $i++)
                                        @if($data && $data->job_status == $i)
                                        <option selected value="{{ $i }}">{{ $statuses[$i] }}</option>
                                        @else
                                        <option value="{{ $i }}">{{ $statuses[$i] }}</option>
                                        @endif
                                    @endfor
                                </select>
                            </div>
                        </div>
                        @if(Auth::user()->type == 'User')
                            <div class="form-group row">
                                <div class="col-sm-3 form-control-label text-muted">Current Company (if status is Employed)</div>
                                <div class="col-sm-9"><input value="@if($data){{ $data->company }}@endif" type="text" name="company" placeholder="Company" class="form-control"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3 form-control-label text-muted">Current Job (if status is Employed)</div>
                                <div class="col-sm-9"><input name="current_job" placeholder="Current Job" value="@if($data){{ $data->current_job }}@endif" type="text" class="form-control"></div>
                            </div>
                        @else
                            <div class="form-group row">
                                <div class="col-sm-3 form-control-label text-muted">Nombers of Employees</div>
                                <div class="col-sm-9"><input name="employees" value="0" placeholder="Number of Employees" value="@if($data){{ $data->employees }}@endif" type="number" class="form-control"></div>
                            </div>
                        @endif
                        {!! Form::hidden('_method', 'PATCH') !!}
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="nw-btn primary-btn genric-btn radius">Save <span class="lnr lnr-arrow-right"></span></button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <hr>
                    <h2>Social Network Links</h2>
                    <hr><br/>
                    {!! Form::open(['url' => route('session.update.social'), 'method' => 'POST']) !!}
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Facebook</div>
                            <div class="col-sm-9"><input value="@if($data){{ $data->facebook }}@endif" type="url" placeholder="https://www.facebook.com/name" name="facebook" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Twitter</div>
                            <div class="col-sm-9"><input name="twitter" placeholder="https://www.twitter.com/username" value="@if($data){{ $data->twitter }}@endif" type="url" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">LinkedIn</div>
                            <div class="col-sm-9"><input value="@if($data){{ $data->linked_in }}@endif" type="url" placeholder="https://www.linkedin.com/username" name="linked_in" class="form-control"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">GitHub(For Developpers and Programmers)</div>
                            <div class="col-sm-9"><input name="github" placeholder="https://www.github.com/username" value="@if($data){{ $data->github }}@endif" type="url" class="form-control"></div>
                        </div>
                        {!! Form::hidden('_method', 'PATCH') !!}
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="nw-btn primary-btn genric-btn radius">Save <span class="lnr lnr-arrow-right"></span></button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <hr>
                    <h2>Biography</h2>
                    <hr><br/>
                    {!! Form::open(['url' => route('session.update.bio'), 'method' => 'POST']) !!}
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Bio</div>
                            <div class="col-sm-9"><textarea value="@if($data){{ $data->about }}@endif" placeholder="About Me..." name="about" class="form-control" style="height:100px;"></textarea></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted">Quote</div>
                            <div class="col-sm-9"><textarea value="@if($data){{ $data->quote }}@endif" placeholder="My Favourite Quote..." name="quote" class="form-control"></textarea></div>
                        </div>
                        {!! Form::hidden('_method', 'PATCH') !!}
                        <div class="form-group row">
                            <div class="col-sm-3 form-control-label text-muted"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="nw-btn primary-btn genric-btn radius">Save <span class="lnr lnr-arrow-right"></span></button>
                            </div>
                        </div>
                    {!! Form::close() !!}
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