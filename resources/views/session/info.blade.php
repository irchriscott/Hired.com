<div class="col-lg-3">
    <div class="hd-profile-identity">
        <h1>{{ Auth::user()->name }}</h1>
        <p class="hd-paragraph-bottom"><span>@</span>{{ Auth::user()->username }}</p>
        <p class="hd-paragraph-d"><span class="lnr lnr-envelope hd-icon-d"></span> <a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></p>
        <p class="hd-paragraph-d"><span class="lnr lnr-map-marker hd-icon-d"></span> {{ Auth::user()->getCountry() }}, {{ Auth::user()->town }}</p>
        <p class="hd-paragraph-d"><span class="lnr lnr-phone-handset hd-icon-d"></span> {{ Auth::user()->getPhoneNumber() }}</p>
        <p class="hd-paragraph-d"><span class="lnr lnr-user hd-icon-d"></span> {{ Auth::user()->type }}</p>
        <p class="hd-paragraph-d"><span class="lnr lnr-briefcase hd-icon-d"></span> {{ Auth::user()->getUserCurrentJob() }}</p>
    </div>
</div>