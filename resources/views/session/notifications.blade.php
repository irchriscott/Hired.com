@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
					<h1 class="text-white" style="text-transform:uppercase;">Notifications</h1>
                    <p class="text-white">See what happened to your posted data</p>
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-jb-container" style="width:40%;">
    <h2>Notifications</h2>
    <p style="float:right; margin-top:-33px;"><a href="{{ route('session.notifications.read.all') }}" data-item="read" id="hd-read-all-notifs">Mark all as Read</a></p>
    <div class="hd-notifications-list">
        @if(count($notifications) > 0)
            <ul>
                @foreach($notifications as $notif)
                    <li @if($notif->is_read == false) style="background:#EEEFFF" @endif>
                        <div class="hd-image">
                            <img src="{{ $notif->userFrom->getProfileImage() }}" alt="{{ $notif->userFrom->username }}" />
                        </div>
                        <div class="hd-not-description">
                            <a href="{{ route('session.notification.read', $notif->id) }}">
                                <h4>{{ $notif->userFrom->name }} <span><span>@</span>{{ $notif->userFrom->username }}</span></h4>
                                <p class="hd-not-about"><span class="lnr {{ $notif->getRessource()[2] }}"></span> {{ $notif->getRessource()[0] }}</p>
                            </a>
                        </div>
                        <div class="hd-description-user-small">
                            <p class="hd-user-name"><span id="hd-datetime-not-{{ $notif->id }}" data-date="{{ $notif->created_at }}"></span></p>
                            <div class="hd-suggestion-menu">
                                <span id="hd-notification-menu-{{ $notif->id }}" data-id="notification-{{ $notif->id }}"><i class="material-icons" style="color:#777777;">more_horiz</i></span>
                                <div class="hd-menu hd-profile-menu" id="hd-menu-notification-{{ $notif->id }}">
                                    <ul>
                                        <li>
                                            <span class="lnr lnr-trash"></span>
                                            <a href="{{ route('session.notification.delete', $notif->id) }}" data-item="delete" id="hd-delete-not-{{ $notif->id }}">Delete</a>
                                        </li>
                                        <div class="dropdown-divider"></div>
                                        <li>
                                            <span class="lnr lnr-eye"></span>
                                            <a href="{{ route('session.notification.read', $notif->id) }}">Read</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <script>$("#hd-notification-menu-{{ $notif->id }}").showMenu(); $("#hd-datetime-not-{{ $notif->id }}").setDate(); $("#hd-delete-not-{{ $notif->id }}").deleteOrReadNotification();</script>
                    </li>
                @endforeach
            </ul>
        @else
            <hr/>
            <p class="hd-error" style="margin:30px 0;">NO NOTIFICATION</p>
        @endif
    </div>
</section>
@endsection