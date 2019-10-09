@if(count($likes) > 0)
    <div class="hd-comments">
        @foreach($likes as $like)
            <div class="hd-comment" style="padding-bottom:13px;">
                <div class="hd-image">
                    <img src="{{ $like->user->getProfileImage() }}" alt="{{ $like->user->username }}" class="img-fluid" />
                </div>
                <div class="hd-about">
                    <a href="{{ route('user.about', $like->user->username) }}"><h4>{{ $like->user->name }} <span>@<span>{{ $like->user->username }}</span></span></h4></a>
                    <p class="hd-text"><span class="lnr lnr-briefcase"></span> {!! $like->user->getUserCurrentJob() !!}</p>
                    <div class="meta-bottom d-flex justify-content-between">
                        <p><span class="lnr lnr-user"></span><a href="{{ route('user.profiles', $like->user->username) }}"> {{ count($like->user->profiles) }} Profiles</a></p>
                        <p><span class="lnr lnr-briefcase"></span><a href="{{ route('user.jobs', $like->user->username) }}"> {{ count($like->user->jobs) }} Jobs</a></p>
                        <p><span class="lnr lnr-layers"></span><a href="{{ route('user.services', $like->user->username) }}"> {{ count($like->user->services) }} Services</a></p>
                        <p><span class="lnr lnr-envelope"></span> <a href="mailto:{{ $like->user->email }}">{{ $like->user->email }}</a></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="hd-error" style="margin:30px 0;">NO LIKES TO BLOG</p>
@endif