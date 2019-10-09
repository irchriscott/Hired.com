<div class="hd-categories-badges" id="hd-form-badges" style="margin:10px 0; text-align:center;">
    @if(count($preferences) > 0)
        @foreach($preferences as $pref)
            <div data-id="{{ $pref->id }}" data-url="{{ route('job.preference.destroy', [$job->id, $pref->id]) }}"  class="hd-badge hd-badge-load-{{ $pref->id }}" data-item="Preference" data-container="hd-profile-preferences" data-loader="{{ route('job.preferences.load', $job->id) }}">
                @csrf
                <div class="hd-badge-content">
                    <span class="hd-b-icon">{!! html_entity_decode($pref->subcategory->getIcon()) !!}</span>
                    <span class="hd-b-text"><a href="#">{{ $pref->subcategory->name }}</a></span>
                    <span class="hd-b-remove hd-remove-btn"><span class="lnr lnr-cross"></span></span>
                </div>
            </div>
            <script>$(".hd-badge-load-{{ $pref->id }}").deleteDataAJAX();</script>
        @endforeach
    @else
        <p class="hd-error">NO PREFERENCES. PLEASE ADD SOME</p>
    @endif
</div>