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
                                    @guest
                                    @else
                                        @if(Auth::user()->id == $suggestion->profile()->id)
                                            <li>
                                                <span class="lnr lnr-trash"></span>
                                                <a href="#" action="{{ route('job.suggestion.destroy', [$job->id, $suggestion->id]) }}" data-url="{{ route('job.suggestions.load.all', $job->id) }}" data-id="{{ $suggestion->id }}" data-container="hd-profile-suggestions-loader" data-item="Suggestion" id="hd-delete-suggestion-{{ $suggestion->id }}">Delete @csrf</a>
                                            </li>
                                        @else
                                            <li>
                                                <span class="lnr lnr-checkmark-circle"></span>
                                                <a href="#" data-status="accepted" action="{{ route('job.suggestion.status.update', [$job->id, $suggestion->id]) }}" data-url="{{ route('job.suggestions.load.all', $job->id) }}" data-id="{{ $suggestion->id }}" data-container="hd-profile-suggestions-loader" class="hd-update-suggestion-status-{{ $suggestion->id }}" data-owner="{{ $suggestion->profile()->user->id }}">Accept @csrf</a>
                                            </li>
                                            <li>
                                                <span class="lnr lnr-cross-circle"></span>
                                                <a href="#" data-status="rejected" action="{{ route('job.suggestion.status.update', [$job->id, $suggestion->id]) }}" data-url="{{ route('job.suggestions.load.all', $job->id) }}" data-id="{{ $suggestion->id }}" data-container="hd-profile-suggestions-loader" class="hd-update-suggestion-status-{{ $suggestion->id }}" data-owner="{{ $suggestion->profile()->user->id }}">Reject @csrf</a>
                                            </li>
                                        @endif
                                    @endguest
                                    <div class="dropdown-divider"></div>
                                    <li>
                                        <span class="lnr lnr-cog"></span>
                                        <a href="#">Report</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <script>$("#hd-suggestion-menu-{{ $suggestion->id }}").showMenu(); $("#hd-delete-suggestion-{{ $suggestion->id }}").deleteWithMenu(); $(".hd-update-suggestion-status-{{ $suggestion->id }}").updateSuggestionStatus(); $("#hd-datetime-sug-{{ $suggestion->id }}").setDate();</script>
                </div>
            </div>
            <hr/>
        @endforeach
        @if(Auth::user()->id == $job->user->id)
            <div style="text-align:center;">
                <a href="{{ route('job.suggestions.manage.all', [$job->id, $job->uuid]) }}" class="genric-btn success large text-uppercase">Manage Suggestions</a>
            </div>
        @endif
    @else
        <p class="hd-error" style="margin:30px 0;">NO POSTED SUGGESTION YET</p>
    @endif
</div>