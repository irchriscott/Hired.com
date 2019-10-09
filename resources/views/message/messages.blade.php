<div class="hd-notifications-list hd-messages-load-all">
    @if(count($messages) > 0)
        <ul>
            @foreach($messages as $message)
                <li @if($message['unread'] > 0) style="background:#EEEFFF" @endif>
                    <div class="hd-image">
                        <img src="{{ $message['message']->userFrom->getProfileImage() }}" alt="{{ $message['message']->userFrom->username }}" />
                    </div>
                    <div class="hd-not-description">
                        @if($message['unread'] > 0)
                        <p class="hd-not-unread">{{$message['unread']}}</p>
                        @endif
                        <a href="{{ route('session.messages.user', $message['message']->userFrom->username) }}">
                            <h5>{{ $message['message']->userFrom->name }} <span><span>@</span>{{ $message['message']->userFrom->username }}</span></h5>
                            <p class="hd-not-about">
                                <span class="lnr {{ $message['last']->messageType()[1] }}"></span>
                                @if($message['last']->userFrom->id ==  Auth::user()->id) 
                                <strong>You : </strong>
                                @else
                                <strong>{{ ucfirst($message['last']->userFrom->username) }} : </strong>
                                @endif
                                {!! $message['last']->messageType()[2] !!}
                            </p>
                        </a>
                    </div>
                    <div class="hd-description-user-small">
                        <p class="hd-user-name"><span id="hd-datetime-not-{{ $message['last']->id }}" data-date="{{ $message['last']->created_at }}"></span></p>
                        <div class="hd-suggestion-menu">
                            <span id="hd-message-menu-{{ $message['last']->id }}" data-id="message-{{ $message['last']->id }}"><i class="material-icons" style="color:#777777;">more_horiz</i></span>
                            <div class="hd-menu hd-profile-menu" id="hd-menu-message-{{ $message['last']->id }}">
                                <ul>
                                    <li>
                                        <span class="lnr lnr-trash"></span>
                                        <a href="" data-item="delete" id="hd-delete-not-{{ $message['message']->id }}">Delete</a>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li>
                                        <span class="lnr lnr-eye"></span>
                                        <a href="{{ route('session.messages.user', $message['message']->userFrom->username) }}">Read</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <script>$("#hd-message-menu-{{ $message['last']->id }}").showMenu(); $("#hd-datetime-not-{{ $message['last']->id }}").setDate();</script>
                </li>
            @endforeach
        </ul>
    @else
        <hr/>
        <p class="hd-error" style="margin:30px 0;">NO MESSAGE</p>
    @endif
</div>