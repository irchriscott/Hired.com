@if(count($responses) > 0)
    <div class="hd-comments">
        @foreach($responses as $response)
            <div class="hd-comment" style="padding-bottom:13px;">
                <div class="hd-image">
                    <img src="{{ $response->user->getProfileImage() }}" alt="{{ $response->user->username }}" class="img-fluid" />
                </div>
                <div class="hd-about">
                    <a href="{{ route('user.about', $response->user->username) }}"><h4>{{ $response->user->name }} <span>@<span>{{ $response->user->username }}</span></span></h4></a>
                    <p class="hd-text">{!! $response->response !!}</p>
                    <div class="meta-bottom d-flex justify-content-between">
                        <p id="hd-datetime-in-{{ $response->id }}" data-date="{{ $response->created_at }}"></p>
                        <p><span class="lnr lnr-envelope"></span> <a href="mailto:{{ $response->user->email }}"> {{ $response->user->email }}</a></p>
                        <div class="hd-comment-menu">
                            <span id="hd-response-menu-{{ $response->id }}" data-id="response-{{ $response->id }}"><i class="material-icons" style="color:#777777;">more_horiz</i></span>
                            <div class="hd-menu hd-profile-menu" id="hd-menu-response-{{ $response->id }}">
                                <ul>
                                    @guest
                                    @else
                                        @if(Auth::user()->id == $response->user->id)
                                            <li>
                                                <span class="lnr lnr-pencil"></span>
                                                <a href="#" id="hd-show-edit-response-{{ $response->id }}" data-toggle="modal" data-target="#hd-response-edit-{{ $response->id }}" data-ui-toggle-class="zoom" data-ui-target="#animate">Edit</a>
                                            </li>
                                            <li>
                                                <span class="lnr lnr-trash"></span>
                                                <a href="#" action="{{ route('blog.response.destroy', [$blog->id, $response->id]) }}" data-url="{{ route('blog.responses.all', $blog->id) }}" data-id="{{ $response->id }}" data-container="hd-profile-reviews-loader" data-item="Response" id="hd-delete-response-{{ $response->id }}">Delete @csrf</a>
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
                    @if(Auth::user()->id == $response->user->id)
                        <div id="hd-response-edit-{{ $response->id }}" class="modal zoom animate" data-backdrop="true">
                            <div class="row-col h-v">
                                <div class="row-cell v-m">
                                    <div class="modal-dialog">
                                        <div class="modal-content hd-review-form">
                                            {!! Form::open(['url' => route('blog.response.update', [$blog->id, $response->id]), 'method' => 'POST', 'data-url' => route('blog.responses.all', $blog->id), 'data-container' => 'hd-profile-reviews-loader', 'id' => 'hd-job-response-form-' . $response->id, 'data-id' => $response->id]) !!}
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Blog Response</h5>
                                                </div>
                                                <div class="modal-body p-lg">  
                                                    {!! Form::hidden('user', Auth::id()) !!}
                                                    {!! Form::textarea('response', $response->response, ['class' => 'hd-response-input form-control', 'placeholder' => 'Enter Review response', 'requited' => true]) !!}
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
                <script>$("#hd-delete-response-{{ $response->id }}").deleteWithMenu(); $("#hd-response-menu-{{ $response->id }}").showMenu();$("#hd-show-edit-response-{{ $response->id }}").click(function(e){e.preventDefault();$("#hd-response-edit-{{ $response->id }}").modal('show');}); $("#hd-job-response-form-{{ $response->id }}").submitComment(); $("#hd-datetime-in-{{ $response->id }}").setDate();</script>
            </div>
        @endforeach
    </div>
@else
    <p class="hd-error" style="margin:30px 0;">NO POSTED RESPONSE</p>
@endif