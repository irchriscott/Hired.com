@extends('layouts.app')

@section('content')
<section class="banner-area relative" id="home" data-parallax="scroll" data-image-src="{{ asset('img/header-bg.jpg')}}">
	<div class="overlay-bg overlay"></div>
	<div class="container">
		<div class="row fullscreen  d-flex align-items-center justify-content-end">
			<div class="banner-content col-lg-6 col-md-12">
				<h1>Very Best <b class="hd-bold">Solution</b> for people <br>to get <b class="hd-bold">Jobs</b></h1>
				<a href="{{ route('jobs') }}" class="primary-btn2 header-btn text-uppercase">Find Jobs Now!</a>
			</div>												
		</div>
	</div>
</section>

<section class="service-area pt-100 pb-150" id="service">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="menu-content pb-70 col-lg-8">
				<div class="title text-center">
					<h1 class="mb-10">Aim &amp; Solutions</h1>
					<p>Hired.com has various aims and solutions and here are some of them</p>
				</div>
			</div>
		</div>	
		<div class="row">
			<div class="sigle-service col-lg-3 col-md-6">
				<span class="lnr lnr-briefcase"></span>
				<h4>Find Jobs</h4>
				<p>
					We help people to find jobs, internships, occupations and services to give in a very easy way.
				</p>
				<a href="#" class="text-uppercase primary-btn2 primary-border circle">View Details</a>
			</div>
			<div class="sigle-service col-lg-3 col-md-6">
				<span class="lnr lnr-magic-wand"></span>
				<h4>Advertise Profiles</h4>
				<p>
					The best way of getting client or jobs is to have a good profile or protifolio and we help you it to advertising it.
				</p>
				<a href="#" class="text-uppercase primary-btn2 primary-border circle">View Details</a>
			</div>
			<div class="sigle-service col-lg-3 col-md-6">
				<span class="lnr lnr-gift"></span>
				<h4>Job Empowerment</h4>
				<p>
					We help workers to get empowered by other people from the blogs, testimonies and profile to see them improve.
				</p>
				<a href="#" class="text-uppercase primary-btn2 primary-border circle">View Details</a>
			</div>
			<div class="sigle-service col-lg-3 col-md-6">
				<span class="lnr lnr-phone"></span>
				<h4>Dedicated Support</h4>
				<p>
					If you need any physical or moral help for your job, we are here to support you and help you. We want to see you excel.
				</p>
			    <a href="#" class="text-uppercase primary-btn2 primary-border circle">View Details</a>
			</div>																		
		</div>
	</div>	
</section>

<section class="about-area">
	<div class="container-fluid">
		<div class="row justify-content-end align-items-center d-flex no-padding">
			<div class="col-lg-6 about-left mt-70">
				<h1>We might need your help as well as our partner</h1>
				<p>
					As you may know, this application is free of charge<br> and it costs us alot for keeping it running and working. <br> If this appliation has helped you by any mean, please dont <br> hesitate to help us by your small danation or contribution.
				</p>
				<div class="buttons">
					<a href="#" class="about-btn text-uppercase primary-border circle">Donate Here</a>
					<a href="#" class="about-btn text-uppercase  primary-border circle">Partner With Us</a>
				</div>
			</div>
			<div class="col-lg-6 about-right">
				<img class="img-fluid" src="{{ asset('img/about.png')}}" alt="">
			</div>
		</div>
	</div>	
</section>

<section class="project-area section-gap" id="project">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="menu-content pb-40 col-lg-8">
				<div class="title text-center">
					<h1 class="mb-10">User Profiles</h1>
					<p>See user profiles you might be interessed in</p>
				</div>
			</div>
		</div>						
		<div class="row">
			<div class="active-works-carousel mt-40">
				@if(count($profiles) > 0)
					@foreach($profiles as $profile)
						<div class="item">
							<img class="hd-carousel-image" src="{{ $profile->images[0]->getImagePath() }}" alt="">
							<div class="caption text-center mt-20">
								<a href="{{ route('user.profile.show', [$profile->id, $profile->uuid]) }}"><h3>{{ $profile->title }}</h3></a>
								<p>{{ $profile->about }}</p>
							</div>
						</div>
					@endforeach
				@else
				@endif
			</div>
		</div>
	</div>	
</section>

<section class="testimonial-area relative section-gap">
	<div class="overlay overlay-bg"></div>
	<div class="container">
	    <div class="row">
			<div class="active-testimonial">
				<div class="single-testimonial item d-flex flex-row">
					<div class="thumb">
						<img class="img-fluid" src="{{ asset('img/user1.png')}}" alt="">
					</div>
					<div class="desc">
						<p>
							Accessories Here you can find the best computer accessory for your laptop, monitor, printer, scanner, speaker, projector, hardware.
						</p>
						<h4 mt-30>Mark Alviro Wiens</h4>
						<p>CEO at Google</p>
					</div>
				</div>
				<div class="single-testimonial item d-flex flex-row">
					<div class="thumb">
						<img class="img-fluid" src="{{ asset('img/user2.png')}}" alt="">
					</div>
					<div class="desc">
						<p>
							Accessories Here you can find the best computer accessory for your laptop, monitor, printer, scanner, speaker, projector, hardware.
						</p>
						<h4 mt-30>Mark Alviro Wiens</h4>
						<p>CEO at Google</p>
					</div>
				</div>								
			</div>					
		</div>
	</div>	
</section>
		
<section class="blog-area section-gap" id="blog">
	<div class="container">
		<div class="row d-flex justify-content-center">
			<div class="menu-content pb-70 col-lg-8">
				<div class="title text-center">
					<h1 class="mb-10">Latest From Our Blog</h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore  et dolore magna aliqua.</p>
				</div>
			</div>
		</div>					
		<div class="row">
			<div class="col-lg-3 col-md-6 single-blog">
				<img class="img-fluid" src="{{ asset('img/b1.jpg')}}" alt="">
				<p class="date">10 Jan 2018</p>
				<h4><a href="#">Addiction When Gambling
				    Becomes A Problem</a></h4>
				<p>
					inappropriate behavior ipsum dolor sit amet, consectetur.
				</p>
				<div class="meta-bottom d-flex justify-content-between">
					<p><span class="lnr lnr-heart"></span> 15 Likes</p>
					<p><span class="lnr lnr-bubble"></span> 02 Comments</p>
				</div>									
			</div>
			<div class="col-lg-3 col-md-6 single-blog">
				<img class="img-fluid" src="{{ asset('img/b2.jpg')}}" alt="">
				<p class="date">10 Jan 2018</p>
				<h4><a href="#">Addiction When Gambling
				    Becomes A Problem</a></h4>
				<p>
					inappropriate behavior ipsum dolor sit amet, consectetur.
				</p>
				<div class="meta-bottom d-flex justify-content-between">
					<p><span class="lnr lnr-heart"></span> 15 Likes</p>
					<p><span class="lnr lnr-bubble"></span> 02 Comments</p>
				</div>									
			</div>
			<div class="col-lg-3 col-md-6 single-blog">
				<img class="img-fluid" src="{{ asset('img/b3.jpg')}}" alt="">
				<p class="date">10 Jan 2018</p>
				<h4><a href="#">Addiction When Gambling
					Becomes A Problem</a></h4>
				<p>
					inappropriate behavior ipsum dolor sit amet, consectetur.
				</p>
				<div class="meta-bottom d-flex justify-content-between">
					<p><span class="lnr lnr-heart"></span> 15 Likes</p>
					<p><span class="lnr lnr-bubble"></span> 02 Comments</p>
				</div>									
			</div>
			<div class="col-lg-3 col-md-6 single-blog">
                <img class="img-fluid" src="{{ asset('img/b4.jpg')}}" alt="">
				<p class="date">10 Jan 2018</p>
				<h4><a href="#">Addiction When Gambling
					Becomes A Problem</a></h4>
				<p>
					inappropriate behavior ipsum dolor sit amet, consectetur.
				</p>
                <div class="meta-bottom d-flex justify-content-between">
                    <p><span class="lnr lnr-heart"></span> 15 Likes</p>
                    <p><span class="lnr lnr-bubble"></span> 02 Comments</p>
                </div>									
		    </div>						
	    </div>
    </div>	
</section>
@endsection
