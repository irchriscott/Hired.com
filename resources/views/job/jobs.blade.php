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
                <div class="hd-categories-badges hd-badge-small">
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