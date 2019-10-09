<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	@guest
	@else
	<meta name="sessionID" content="{{ Auth::user()->id }}" />
	<meta name="sessionUsername" content="{{ Auth::user()->username }}" />
	<meta name="sessionName" content="{{ Auth::user()->name }}" />
	<meta name="sessionToken" content="{{ Auth::user()->remember_token }}" />
	@endguest
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
	<link href="{{ asset('css/main.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/linearicons.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/material/material.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/animate.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('toast/iziToast.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('popup/magnific-popup.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/froala_style.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/froala_editor.pkgd.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('datepicker/datepicker.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('js/vendor/jquery-2.2.4.min.js') }}"></script>
	<script type="text/javascript" src="http://127.0.0.1:8008/socket.io/socket.io.js"></script>
	<script src="https://unpkg.com/popper.js@1.14.3/dist/umd/popper.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2mLGusTJZqu7zesBgobnoVIzN6hIayvk&libraries=places,geometry"></script>
	<script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/parallax.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('js/jquery.donutwidget.min.js') }}"></script>
	<script src="{{ asset('toast/iziToast.min.js') }}"></script>
	<script src="{{ asset('popup/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('js/jquery.niceselect.min.js') }}"></script>
	<script src="{{ asset('js/froala_editor.pkgd.min.js') }}"></script>
	<script src="{{ asset('js/ui.js') }}"></script>
	<script src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('datepicker/datepicker.min.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
</head>
<body>
	@include('layouts.messages')
    <div id="app">
        <header class="default-header">
			<nav class="navbar navbar-expand-lg  navbar-light">
				<div class="container">
					<a class="navbar-brand" href="{{ route('home') }}">
                        <h3 class="hd-app-name"><span class="hd-app-name-1">Hired</span><span class="hd-app-name-2">.com</span></h3>
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">
						<ul class="navbar-nav">
							<li><a href="{{ route('jobs') }}">Jobs</a></li>
							<li><a href="{{ route('services') }}">Services</a></li>
							<li><a href="{{ route('blogs') }}">Blogs</a></li>
							<li><a href="{{ route('categories') }}">Categories</a></li>
							@guest
							@else
							<li>
								<a href="{{ route('session.notifications') }}" class="hd-menu-icon" title="Notifications">
									<span class="lnr lnr-alarm"></span>
									<span class="hd-menu-not" @if(Auth::user()->unreadNotsCount() <= 0) style="display:none;" @endif id="hd-session-notifications">{{ Auth::user()->unreadNotsCount() }}</span>
								</a>
							</li>
							<li>
								<a href="{{ route('session.messages.all') }}" class="hd-menu-icon" title="Messages">
									<span class="lnr lnr-envelope"></span>
									<span class="hd-menu-not" style="margin-left:0px; @if(Auth::user()->unreadMessagesCount() <= 0) display:none; @endif">{{ Auth::user()->unreadMessagesCount() }}</span>
								</a>
							</li>
							@endguest
							<li>
								<a href="#" class="hd-menu-icon">
									<span class="lnr lnr-magnifier"></span>
								</a>
							</li>
							@guest
                                <li><a href="{{ route('login') }}" class="text-uppercase primary-btn2 primary-border circle hd-link-header">Sign In</a></li>
							@else
								<input type="hidden" id="session_userid" value="{{ Auth::user()->id }}" />
								<input type="hidden" id="session_username" value="{{ Auth::user()->username }}" />
								<input type="hidden" id="session_name" value="{{ Auth::user()->name }}" />
								<li>
									<div class="hd-menu-image">
										<a class="nav-link text-muted" data-id="nav" id="hd-nav-menu" title="{{ Auth::user()->username }}">
										<img src="{{ Auth::user()->getProfileImage() }}" alt="{{ Auth::user()->username }}">
										</a>
									</div>
									<div class="hd-menu hd-nav-menu" id="hd-menu-nav">
										<ul>
											<li>
												<span class="lnr lnr-layers"></span>
												<a href="{{ route('session.services') }}">Services</a>
											</li>
											<li>
												<span class="lnr lnr-briefcase"></span>
												<a href="{{ route('session.jobs') }}">Jobs</a>
											</li>
											<li>
												<span class="lnr lnr-user"></span>
												<a href="{{ route('session.profiles') }}">Profiles</a>
											</li>
											<li>
												<span class="lnr lnr-text-align-left"></span>
												<a href="{{ route('session.blogs') }}">Blogs</a>
											</li>
											<li>
												<span class="lnr lnr-pointer-right"></span>
												<a href="{{ route('session.about') }}">About</a>
											</li>
											<div class="dropdown-divider"></div>
											<li>
												<span class="lnr lnr-cog"></span>
												<a href="#">Settings</a>
											</li>
											<div class="dropdown-divider"></div>
											<li>
												<span class="lnr lnr-exit"></span>
												<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                						document.getElementById('logout-form').submit();">Logout</a>
												<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
													@csrf
												</form>
											</li>
										</ul>
									</div>
								</li>
								<li>

								</li>
							@endguest							
					    </ul>
					</div>						
				</div>
			</nav>
		</header>
        <main>
            @yield('content')
        </main>
        <footer class="footer-area section-gap">
			<div class="container">
				<div class="row">
					<div class="col-lg-3  col-md-12">
						<div class="single-footer-widget">
							<h5><span class="hd-app-name-1">Hired</span><span class="hd-app-name-2">.com</span></h5>
							<ul class="footer-nav">
								<li><a href="#">Terms &amp; Conditions</a></li>
								<li><a href="#">Terms &amp; Usage</a></li>
								<li><a href="#">Data Security</a></li>
								<li><a href="#">Major Rules</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-6  col-md-12">
						<div class="single-footer-widget newsletter">
							<h6>Newsletter</h6>
							<p>You can trust us. we only send promo offers, not a single spam.</p>
							<div id="mc_embed_signup">
								<form novalidate="true" action="#" method="get" class="form-inline">
									<div class="form-group row" style="width: 100%">
										<div class="col-lg-8 col-md-12">
											<input name="EMAIL" placeholder="Enter Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '" required="" type="email">
											<div style="position: absolute; left: -5000px;">
												<input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
											</div>
										</div> 					
										<div class="col-lg-4 col-md-12">
											<button class="nw-btn primary-btn">Subscribe<span class="lnr lnr-arrow-right"></span></button>
										</div> 
									</div>		
									<div class="info"></div>
								</form>
							</div>		
						</div>
					</div>
					<div class="col-lg-3  col-md-12">
						<div class="single-footer-widget mail-chimp">
							<h6 class="mb-20">Instragram Feed</h6>
							<ul class="instafeed d-flex flex-wrap">
								<li><img src="img/i1.jpg" alt=""></li>
								<li><img src="img/i2.jpg" alt=""></li>
								<li><img src="img/i3.jpg" alt=""></li>
								<li><img src="img/i4.jpg" alt=""></li>
								<li><img src="img/i5.jpg" alt=""></li>
								<li><img src="img/i6.jpg" alt=""></li>
								<li><img src="img/i7.jpg" alt=""></li>
								<li><img src="img/i8.jpg" alt=""></li>
							</ul>
						</div>
					</div>						
				</div>
				<div class="row footer-bottom d-flex justify-content-between">
                    <p class="col-lg-8 col-sm-12 footer-text m-0 text-white">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This web application is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="#" target="_blank">Code Pipes Solutions</a></p>
					<div class="col-lg-4 col-sm-12 footer-social">
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-dribbble"></i></a>
						<a href="#"><i class="fa fa-behance"></i></a>
					</div>
				</div>
			</div>
		</footer>
    </div>
</body>
</html>
