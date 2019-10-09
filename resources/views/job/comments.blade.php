@if(count($comments) > 0)
    <div class="hd-comments">
        @foreach($comments as $comment)
            <div class="hd-comment" style="padding-bottom:13px;">
                <div class="hd-image">
                    <img src="{{ $comment->user->getProfileImage() }}" alt="{{ $comment->user->username }}" class="img-fluid" />
                </div>
                <div class="hd-about">
                    <a href="{{ route('user.about', $comment->user->username) }}"><h4>{{ $comment->user->name }} <span>@<span>{{ $comment->user->username }}</span></span></h4></a>
                    <p class="hd-text">{!! $comment->comment !!}</p>
                    <div class="meta-bottom d-flex justify-content-between">
                        <p id="hd-datetime-in-{{ $comment->id }}" data-date="{{ $comment->created_at }}"></p>
                        <p><span class="lnr lnr-envelope"></span> <a href="mailto:{{ $comment->user->email }}"> {{ $comment->user->email }}</a></p>
                        <div class="hd-comment-menu">
                            <span id="hd-comment-menu-{{ $comment->id }}" data-id="comment-{{ $comment->id }}"><i class="material-icons" style="color:#777777;">more_horiz</i></span>
                            <div class="hd-menu hd-profile-menu" id="hd-menu-comment-{{ $comment->id }}">
                                <ul>
                                    @guest
                                    @else
                                        @if(Auth::user()->id == $comment->user->id)
                                            <li>
                                                <span class="lnr lnr-pencil"></span>
                                                <a href="#" id="hd-show-edit-comment-{{ $comment->id }}" data-toggle="modal" data-target="#hd-comment-edit-{{ $comment->id }}" data-ui-toggle-class="zoom" data-ui-target="#animate">Edit</a>
                                            </li>
                                            <li>
                                                <span class="lnr lnr-trash"></span>
                                                <a href="#" action="{{ route('job.comment.destroy', [$job->id, $comment->id]) }}" data-url="{{ route('job.comments.all', $job->id) }}" data-id="{{ $comment->id }}" data-container="hd-profile-reviews-loader" data-item="Comment" id="hd-delete-comment-{{ $comment->id }}">Delete @csrf</a>
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
                    @if(Auth::user()->id == $comment->user->id)
                        <div id="hd-comment-edit-{{ $comment->id }}" class="modal zoom animate" data-backdrop="true">
                            <div class="row-col h-v">
                                <div class="row-cell v-m">
                                    <div class="modal-dialog">
                                        <div class="modal-content hd-review-form">
                                            {!! Form::open(['url' => route('job.comment.update', [$job->id, $comment->id]), 'method' => 'POST', 'data-url' => route('job.comments.all', $job->id), 'data-container' => 'hd-profile-reviews-loader', 'id' => 'hd-job-comment-form-' . $comment->id, 'data-id' => $comment->id]) !!}
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit {{ ucfirst($job->job_type) }} Comment</h5>
                                                </div>
                                                <div class="modal-body p-lg">  
                                                    {!! Form::hidden('user', Auth::id()) !!}
                                                    {!! Form::textarea('comment', $comment->comment, ['class' => 'hd-comment-input form-control', 'placeholder' => 'Enter Review Comment', 'requited' => true]) !!}
                                                </div>
                                                {!! Form::hidden('_method', 'PATCH') !!}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" id="hd-submit" class="btn primary p-x-md">Update</button>
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <script>$("#hd-delete-comment-{{ $comment->id }}").deleteWithMenu(); $("#hd-comment-menu-{{ $comment->id }}").showMenu();$("#hd-show-edit-comment-{{ $comment->id }}").click(function(e){e.preventDefault();$("#hd-comment-edit-{{ $comment->id }}").modal('show');}); $("#hd-job-comment-form-{{ $comment->id }}").submitComment(); $("#hd-datetime-in-{{ $comment->id }}").setDate();</script>
            </div>
        @endforeach
    </div>
@else
    <p class="hd-error" style="margin:30px 0;">NO COMMENT TO THIS {{ strtoupper($job->job_type) }}</p>
@endif