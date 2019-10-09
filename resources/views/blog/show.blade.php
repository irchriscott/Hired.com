@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">{{ $blog->title }}</h1>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-bg-content">
    <div class="hd-profile-image">
        <div class="hd-profile-image-container">
            <div class="box hd-session-profile-image">
                <div class="item light hd-session-profile-image">
                    <img class="hd-session-profile-image-img" src="{{ $blog->user->getProfileImage() }}" alt="{{ $blog->user->username }}" class="w-full">
                </div>
            </div>
        </div>
    </div>
    <div class="hd-menu-user nav-active-border">
        <div class="hd-profile-user-menu">
            <div class="hd-image"><img src="{{ $blog->user->getProfileImage() }}" alt="{{ $blog->user->username }}"></div>
            <div class="hd-about"><h5>{{ $blog->user->name }}</h5><p><span>@</span>{{ $blog->user->username }}</p></div>
        </div>
        <ul class="nav nav-md">
            <li class="nav-item inline">
                <a class="nav-link active" href="#" data-toggle="tab" data-target="#blog">
                    <span class="text-md">Blog Content</span>
                    <small class="block text-muted hidden-xs">See all blog content</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link" href="#" data-toggle="tab" data-target="#comments">
                    <span class="text-md">Responses</span>
                    <small class="block text-muted hidden-xs">See all responses</small>
                </a>
            </li>
            <li class="nav-item inline">
                <a class="nav-link" href="#" data-toggle="tab" data-target="#likes">
                    <span class="text-md">Likes</span>
                    <small class="block text-muted hidden-xs">People who liked this blog</small>
                </a>
            </li>
        </ul>
        <div class="hd-data-menu">
            <span class="hd-data-menu-btn" data-id="profile"><span class="lnr lnr-chevron-down"></span></span>
            <div class="hd-menu hd-profile-menu" id="hd-menu-profile">
				<ul>
                    @guest
                        <li>
                            <span class="lnr lnr-enter"></span>
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li>
                            <span class="lnr lnr-cog"></span>
                            <a href="#">Report</a>
                        </li>
                    @else
                        @if(Auth::id() == $blog->user->id)
                            <li>
                                <span class="lnr lnr-pencil"></span>
                                <a href="{{ route('user.blog.edit', [$blog->id, $blog->uuid]) }}">Edit</a>
                            </li>
                            <li>
                                <span class="lnr lnr-trash"></span>
                                <a href="#" id="delete-submit-btn" data-item="Blog">Delete</a>
                            </li>
                            {!! Form::open(['url' => route('user.blog.delete', [$blog->id, $blog->uuid]), 'method' => 'POST', 'id' => 'hd-delete-form']) !!}{!! Form::hidden('_method', 'DELETE') !!}{!! Form::close() !!}
                        @endif
                        <li>
                            <span class="lnr lnr-bubble"></span>
                            <a href="#hd-review-profile" id="hd-show-review-model" data-toggle="modal" data-target="#hd-review-profile">Respond</a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li>
                            <span class="lnr lnr-envelope"></span>
                            <a href="{{ route('session.messages.user', $blog->user->username) }}">Message</a>
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
    <div class="row-col row hd-row-col" id="hd-data-tab-content" style="margin:0;">
        <div class="col-lg-3">
            <div class="hd-profile-identity">
                <a href="{{ route('user.about', $blog->user->username) }}"><h1>{{ $blog->user->name }}</h1></a>
                <p class="hd-paragraph-bottom"><span>@</span>{{ $blog->user->username }}</p>
                <p class="hd-paragraph-d"><span class="lnr lnr-envelope hd-icon-d"></span> <a href="mailto:{{ $blog->user->email }}">{{ $blog->user->email }}</a></p>
                <p class="hd-paragraph-d"><span class="lnr lnr-map-marker hd-icon-d"></span> {{ $blog->user->getCountry() }}, {{ $blog->user->town }}</p>
                <p class="hd-paragraph-d"><span class="lnr lnr-phone-handset hd-icon-d"></span> {{ $blog->user->getPhoneNumber() }}</p>
                <p class="hd-paragraph-d"><span class="lnr lnr-user hd-icon-d"></span> {{ $blog->user->type }}</p>
                <p class="hd-paragraph-d"><span class="lnr lnr-briefcase hd-icon-d"></span> {{ $blog->user->getUserCurrentJob() }}</p>
                <p class="hd-paragraph-d"><span class="lnr lnr-clock hd-icon-d"></span> <span id="hd-datetime-in" data-date="{{ $blog->created_at }}"></span></p>
            </div>
        </div>
        <div class="tab-content col-lg-6 no-border-md" style="margin-top:5px;">
            <div class="tab-pane active" id="blog">
                <div class="hd-content-data" style="padding-top:30px;">
                    <div style="padding-bottom:10px;" class="hd-friola-content">{!! $blog->blog !!}</div>
                    <hr/>
                    <div class="hd-categories-badges" id="hd-form-badges" style="margin:10px 0;">
                        @if(count($preferences) > 0)
                            @foreach($preferences as $pref)
                                <div class="hd-badge">
                                    @csrf
                                    <div class="hd-badge-content">
                                        <span class="hd-b-icon">{!! html_entity_decode($pref->subcategory->getIcon()) !!}</span>
                                        <span class="hd-b-text"><a href="{{ route('category.subcategory.data.get', [$pref->category->id, $pref->subcategory->id]) }}">{{ $pref->subcategory->name }}</a></span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="hd-error">NO PREFERENCES. PLEASE ADD SOME</p>
                        @endif
                    </div>
                    <hr/>
                    <div class="hd-content-menu">
                        <ul>
                            <li>
                                <input type="checkbox" id="profile-like" @if($isLiked == true) checked @endif />
                                <label for="profile-like" class="hd-like-btn" data-owner="{{ $blog->user->id }}" data-from="blog" data-user="{{ Auth::id() }}" id="blog-like-btn" data-id="{{ $blog->id }}" data-url="{{ route('user.blog.like', [$blog->id, $blog->uuid]) }}" data-loader="{{ route('user.blog.likes.all', $blog->id) }}">
                                    @csrf
                                    <svg id="heart-svg" viewBox="467 392 58 57" xmlns="http://www.w3.org/2000/svg">
                                        <g id="Group" fill="none" fill-rule="evenodd" transform="translate(467 392)">
                                            <path d="M29.144 20.773c-.063-.13-4.227-8.67-11.44-2.59C7.63 28.795 28.94 43.256 29.143 43.394c.204-.138 21.513-14.6 11.44-25.213-7.214-6.08-11.377 2.46-11.44 2.59z" id="heart" fill="#AAB8C2"/>
                                            <circle id="main-circ" fill="#E2264D" opacity="0" cx="29.5" cy="29.5" r="1.5"/>
                                            <g id="grp7" opacity="0" transform="translate(7 6)">
                                                <circle id="oval1" fill="#9CD8C3" cx="2" cy="6" r="2"/>
                                                <circle id="oval2" fill="#8CE8C3" cx="5" cy="2" r="2"/>
                                            </g>
                                            <g id="grp6" opacity="0" transform="translate(0 28)">
                                                <circle id="oval1" fill="#CC8EF5" cx="2" cy="7" r="2"/>
                                                <circle id="oval2" fill="#91D2FA" cx="3" cy="2" r="2"/>
                                            </g>
                                            <g id="grp3" opacity="0" transform="translate(52 28)">
                                                <circle id="oval2" fill="#9CD8C3" cx="2" cy="7" r="2"/>
                                                <circle id="oval1" fill="#8CE8C3" cx="4" cy="2" r="2"/>
                                            </g>
                                            <g id="grp2" opacity="0" transform="translate(44 6)">
                                                <circle id="oval2" fill="#CC8EF5" cx="5" cy="6" r="2"/>
                                                <circle id="oval1" fill="#CC8EF5" cx="2" cy="2" r="2"/>
                                            </g>
                                            <g id="grp5" opacity="0" transform="translate(14 50)">
                                                <circle id="oval1" fill="#91D2FA" cx="6" cy="5" r="2"/>
                                                <circle id="oval2" fill="#91D2FA" cx="2" cy="2" r="2"/>
                                            </g>
                                            <g id="grp4" opacity="0" transform="translate(35 50)">
                                                <circle id="oval1" fill="#F48EA7" cx="6" cy="5" r="2"/>
                                                <circle id="oval2" fill="#F48EA7" cx="2" cy="2" r="2"/>
                                            </g>
                                            <g id="grp1" opacity="0" transform="translate(24)">
                                                <circle id="oval1" fill="#9FC7FA" cx="2.5" cy="3" r="2"/>
                                                <circle id="oval2" fill="#9FC7FA" cx="7.5" cy="2" r="2"/>
                                            </g>
                                        </g>
                                    </svg>
                                </label>
                                <p class="hd-numbers"><span class="hd-number-add" id="hd-number-add">+1</span><span id="like-sum">{{ $blog->likesCount() }}</span></p>
                            </li>
                            <li>
                                <div class="hd-icon"><span class="lnr lnr-bubble"></span><p style="margin-left:15px;" class="hd-numbers" id="hd-sum-comments">{{ $blog->responsesCount() }}</p></div>
                            </li>
                        </ul>
                    </div>
                    <div class="hd-similar-others">
                        <h3>Similar Blogs</h3>
                        <div class="row">
                            @if(count($blogs) > 0)
                                @foreach($blogs as $blg)
                                    <div class="col-xs-4 col-sm-12 col-md-4">
                                        <div class="hd-box box">
                                            <div class="item dark">
                                                <a href="#" onclick="event.preventDefault()" ><img src="{{ $blg->user->getProfileImage() }}" alt="." class="w-full"></a>
                                                <div class="bottom gd-overlay p-a-xs">
                                                    <a href="{{ route('user.blogs', $blg->user->username) }}" class="text-md block p-x-sm" style="color:#FFFFFF;">{{ $blg->user->name }}</a>
                                                </div>
                                            </div>
                                            <a class="md-btn md-raised md-fab md-mini m-r pos-rlt md-fab-offset pull-right white"><i class="material-icons md-24" style="color:#777;">add</i></a>
                                            <div class="p-a">
                                                <div class="text-muted m-b-xs">
                                                    <a href="#" onclick="event.preventDefault()" class="m-r" style="color:#777;"><span class="lnr lnr-heart"></span> {{ $blg->likesCount() }}</a>
                                                    <a href="#" onclick="event.preventDefault()" style="color:#777;"><span class="lnr lnr-bubble"></span> {{ $blg->responsesCount() }}</a>
                                                </div>
                                                <a href="{{ route('user.blog.show', [$blog->id, $blog->uuid]) }}"><h5>{{ $blog->title }}</h5></a>
                                                <span class="m-r text-muted" style="font-size:12px; margin-bottom:5px; display:block;" data-date="{{ $blg->created_at }}" id="hd-blg-date-{{ $blg->id }}"></span>
                                                <div><a href="{{ route('user.blog.show', [$blog->id, $blog->uuid]) }}" class="btn btn-xs white">Read More</a></div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>$("#hd-blg-date-{{ $blg->id }}").setDate();</script>
                                @endforeach
                            @else
                                <p class="hd-error">NO SIMILAR BLOGS</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="comments">
                <div id="hd-profile-reviews-loader">
                    <div class="hd-spinner" style="display:block; margin:30px 0;"><span><i class="fa fa-spin fa-spinner"></i></span></div>
                </div>
                <script>loadHTMLAjax("hd-profile-reviews-loader", "{{ route('blog.responses.all', $blog->id) }}")</script>
            </div>
            <div class="tab-pane" id="likes">
                <div id="hd-profile-likes-loader">
                    <div class="hd-spinner" style="display:block; margin:30px 0;"><span><i class="fa fa-spin fa-spinner"></i></span></div>
                </div>
                <script>loadHTMLAjax("hd-profile-likes-loader", "{{ route('user.blog.likes.all', $blog->id) }}")</script>
            </div>
        </div>
    </div>
    @guest
    @else
    <div id="hd-review-profile" class="modal zoom animate" data-backdrop="true">
        <div class="row-col h-v">
            <div class="row-cell v-m">
                <div class="modal-dialog">
                    <div class="modal-content hd-review-form">
                        {!! Form::open(['url' => route('blog.response.store', $blog->id), 'method' => 'POST', 'class' => 'hd-comment-form', 'data-from' => 'blog', 'data-owner' => $blog->user->id, 'data-id' => $blog->id, 'data-url' => route('blog.responses.all', $blog->id), 'data-container' => 'hd-profile-reviews-loader', 'id' => 'hd-profile-review-form']) !!}
                            <div class="modal-header">
                                <h5 class="modal-title">Add Response</h5>
                            </div>
                            <div class="modal-body p-lg">  
                                {!! Form::hidden('user', Auth::id()) !!}
                                {!! Form::textarea('response', '', ['class' => 'hd-comment-input form-control', 'placeholder' => 'Enter Response', 'required' => true]) !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
                                <button type="submit" id="hd-submit" class="btn primary p-x-md">Save</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endguest
</section>
@endsection