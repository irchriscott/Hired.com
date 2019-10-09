@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">JOB SUGGESTIONS</h1>
                    <p class="text-white">{{ $job->title }} - {{ $job->position }}</p>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-jb-container" style="width:55%;">
    <h2 style="margin-top: 0 !important;">Suggestions</h2>
    <div style="margin-top:20px;">
        @if(count($suggestions) > 0)
            <hr/>
            @foreach($suggestions as $suggestion)
                <div class="row">
                    <div class="hd-status-teller" title="{{ $suggestion->status }}" style="background: {{ $suggestion->getStatusColor() }}"></div>
                    <div class="col-md-4 hd-image">
                        <img style="margin-left:4px;" src="{{ $suggestion->profile()->images[0]->getImagePath() }}" alt="{{ $suggestion->profile()->title }}" class="img-fluid">
                    </div>
                    <div class="col-md-8 mt-sm-20">
                        <a href="{{ route('user.profile.show', [$suggestion->profile()->id, $suggestion->profile()->uuid]) }}"><h2>{{ $suggestion->profile()->title }}</h2></a>
                        <p>{{ $suggestion->profile()->about }}</p>
                        <div class="hd-categories-badges hd-badge-small" style="margin-top:-8px; margin-bottom:6px;" id="hd-form-badges">
                            @if(count($suggestion->profile()->preferences) > 0)
                                @foreach($suggestion->profile()->preferences as $pref)
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
                            <img src="{{ $suggestion->profile()->user->getProfileImage() }}" alt="{{ $suggestion->profile()->user->username }}" />
                            <p class="hd-user-name"><a href="{{ route('user.about', $suggestion->profile()->user->username) }}" target="_blank">{{ $suggestion->profile()->user->name }} <span><span>@</span>{{ $suggestion->profile()->user->username }}</span></a> - <span id="hd-datetime-sug-{{ $suggestion->id }}" data-date="{{ $suggestion->created_at }}"></span></p>
                            <div class="hd-suggestion-menu">
                                <span id="hd-suggestion-menu-{{ $suggestion->id }}" data-id="suggestion-{{ $suggestion->id }}"><i class="material-icons" style="color:#777777;">more_horiz</i></span>
                                <div class="hd-menu hd-profile-menu" id="hd-menu-suggestion-{{ $suggestion->id }}">
                                    <ul>
                                        <li>
                                            <span class="lnr lnr-checkmark-circle"></span>
                                            <a class="hd-suggestion-update-status-{{ $suggestion->id }}" href="{{ route('job.suggestion.status.update.else', [$job->id, $suggestion->id]) }}?status=accepted" data-status="Accepted" data-owner="{{ $suggestion->profile()->user->id }}">Accept</a>
                                        </li>
                                        <li>
                                            <span class="lnr lnr-cross-circle"></span>
                                            <a class="hd-suggestion-update-status-{{ $suggestion->id }}" href="{{ route('job.suggestion.status.update.else', [$job->id, $suggestion->id]) }}?status=rejected" data-status="Rejected" data-owner="{{ $suggestion->profile()->user->id }}">Reject</a>
                                        </li>
                                        <li>
                                            <span class="lnr lnr-download"></span>
                                            <a href="{{ route('job.suggestion.cv.download', [$job->id, $suggestion->id, $job->uuid]) }}">Get CV</a>
                                        </li>
                                        <div class="dropdown-divider"></div>
                                        <li>
                                            <span class="lnr lnr-cog"></span>
                                            <a href="#">Report</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <script>$("#hd-suggestion-menu-{{ $suggestion->id }}").showMenu(); $("#hd-delete-suggestion-{{ $suggestion->id }}").deleteWithMenu(); $(".hd-suggestion-update-status-{{ $suggestion->id }}").updateSuggestionStatusElse(); $("#hd-datetime-sug-{{ $suggestion->id }}").setDate();</script>
                    </div>
                </div>
                <hr/>
            @endforeach
        @else
            <p class="hd-error" style="margin:30px 0;">NO POSTED SUGGESTION YET</p>
        @endif
    </div>
    <div style="text-align:center;">
        <a href="{{ route('job.suggestions.export.excel', $job->id) }}" class="genric-btn success large text-uppercase">Export To Excel</a>
        <a href="{{ route('job.suggestions.email.create', [$job->id, $job->uuid]) }}" class="genric-btn success large text-uppercase">Send Email</a>
    </div>
</section>
@endsection