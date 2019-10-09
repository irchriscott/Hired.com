<div>
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