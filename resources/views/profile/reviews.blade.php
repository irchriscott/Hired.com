@if(count($reviews) > 0)
    <div class="hd-comments">
        @foreach($reviews as $review)
            <div class="hd-comment">
                <div class="hd-image">
                    <img src="{{ $review->user->getProfileImage() }}" alt="{{ $review->user->username }}" class="img-fluid" />
                </div>
                <div class="hd-about">
                    <a href="{{ route('user.about', $review->user->username) }}"><h4>{{ $review->user->name }} <span>@<span>{{ $review->user->username }}</span></span></h4></a>
                    <p class="hd-text">{!! $review->comment !!}</p>
                    <div class="meta-bottom d-flex justify-content-between">
                        <p id="hd-datetime-in-{{ $review->id }}" data-date="{{ $review->created_at }}"></p>
                        <div class="hd-rate-stars" id="hd-rate-stars-review-{{ $review->id }}">
                            <input class="star star-5" type="radio" name="star" value="5" disabled/>
                            <label class="star star-5"></label>
                            <input class="star star-4" type="radio" name="star" value="4" disabled/>
                            <label class="star star-4"></label>
                            <input class="star star-3" type="radio" name="star" value="3" disabled/>
                            <label class="star star-3"></label>
                            <input class="star star-2" type="radio" name="star" value="2" disabled/>
                            <label class="star star-2"></label>
                            <input class="star star-1" type="radio" name="star" value="1" disabled/>
                            <label class="star star-1"></label>
                        </div>
                        <div class="hd-comment-menu">
                            <span id="hd-review-menu-{{ $profile->id }}" data-id="review-{{ $review->id }}"><i class="material-icons" style="color:#777777;">more_horiz</i></span>
                            <div class="hd-menu hd-profile-menu" id="hd-menu-review-{{ $review->id }}">
                                <ul>
                                    @guest
                                    @else
                                        @if(Auth::user()->id == $review->user->id)
                                            <li>
                                                <span class="lnr lnr-pencil"></span>
                                                <a href="#" id="hd-show-edit-review-{{ $review->id }}" data-toggle="modal" data-target="#hd-review-edit-{{ $review->id }}" data-ui-toggle-class="zoom" data-ui-target="#animate">Edit</a>
                                            </li>
                                            <li>
                                                <span class="lnr lnr-trash"></span>
                                                <a href="#" action="{{ route('user.profile.review.destroy', [$profile->id, $review->id]) }}" data-url="{{ route('user.profile.reviews.all', $profile->id) }}" data-id="{{ $review->id }}" data-container="hd-profile-reviews-loader" data-item="Review" id="hd-delete-review-{{ $review->id }}">Delete @csrf</a>
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
                    @if(Auth::user()->id == $review->user->id)
                        <div id="hd-review-edit-{{ $review->id }}" class="modal zoom animate" data-backdrop="true">
                            <div class="row-col h-v">
                                <div class="row-cell v-m">
                                    <div class="modal-dialog">
                                        <div class="modal-content hd-review-form">
                                            {!! Form::open(['url' => route('user.profile.review.update', [$profile->id, $review->id]), 'method' => 'POST', 'data-url' => route('user.profile.reviews.all', $profile->id), 'data-container' => 'hd-profile-reviews-loader', 'id' => 'hd-profile-review-form-' . $review->id, 'data-id' => $review->id]) !!}
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Profile Review</h5>
                                                </div>
                                                <div class="modal-body p-lg">  
                                                    {!! Form::hidden('user', Auth::id()) !!}
                                                    <div class="hd-rate-stars hd-stars-form" id="hd-stars-edit-form-{{ $review->id }}">
                                                        <input class="star star-5" id="star-5-2-{{ $review->id }}" type="radio" name="star" value="5"/>
                                                        <label class="star star-5" for="star-5-2-{{ $review->id }}"></label>
                                                        <input class="star star-4" id="star-4-2-{{ $review->id }}" type="radio" name="star" value="4"/>
                                                        <label class="star star-4" for="star-4-2-{{ $review->id }}"></label>
                                                        <input class="star star-3" id="star-3-2-{{ $review->id }}" type="radio" name="star" value="3"/>
                                                        <label class="star star-3" for="star-3-2-{{ $review->id }}"></label>
                                                        <input class="star star-2" id="star-2-2-{{ $review->id }}" type="radio" name="star" value="2"/>
                                                        <label class="star star-2" for="star-2-2-{{ $review->id }}"></label>
                                                        <input class="star star-1" id="star-1-2-{{ $review->id }}" type="radio" name="star" value="1"/>
                                                        <label class="star star-1" for="star-1-2-{{ $review->id }}"></label>
                                                    </div>
                                                    {!! Form::textarea('comment', $review->comment, ['class' => 'hd-comment-input form-control', 'placeholder' => 'Enter Review Comment', 'requited' => true]) !!}
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
                <script>$("#hd-rate-stars-review-{{ $review->id }}").setReviewStars({{ $review->review }}); $("#hd-review-menu-{{ $profile->id }}").showMenu(); $("#hd-show-edit-review-{{ $review->id }}").click(function(e){e.preventDefault();$("#hd-review-edit-{{ $review->id }}").modal('show');}); $("#hd-profile-review-form-{{ $review->id }}").submitComment(); $("#hd-stars-edit-form-{{ $review->id }}").setReviewStars({{ $review->review }}); $("#hd-delete-review-{{ $review->id }}").deleteWithMenu(); $("#hd-datetime-in-{{ $review->id }}").setDate();</script>
            </div>
        @endforeach
    </div>
@else
    <p class="hd-error" style="margin:30px 0;">NO REVIEWS TO THIS PROFILE</p>
@endif