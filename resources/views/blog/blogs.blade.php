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