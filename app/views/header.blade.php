<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" lang="en-US">
<![endif]-->
<!--[if IE 7]>
<html id="ie7" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" lang="en-US">
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html lang="en-US">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<title>@if(isset($title)){{'iRate Politics: '.$title}}@else iRate Politics @endif</title>
	

<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-tour.min.css">

<link rel="stylesheet" type="text/css" media="all" href="/assets/css/star-rating.min.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/style.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/politicians.css" />


<link rel="stylesheet" type="text/css" media="all" href="/assets/css/jcloud.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/mobile.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/sharing.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/print.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/home.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/about.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/sign-up.css" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/mobile.css" />
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon"/>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>





<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-37258698-1', 'auto');
ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>

 	<meta property="og:site_name" content="IratePolitics"/>
        <meta property="og:type"   content="website" /> 
	<meta property="fb:app_id" content="785123928176736" /> 

@if(isset($fb_og))
	@foreach($fb_og as $key => $value)
		@if(isset($value))
			<meta property="og:{{$key}}"             content="{{$value}}" /> 
		@endif
	@endforeach		
	
@else
	<meta property="og:url"             content="{{Request::url()}}" /> 

@endif

</head>

<body class="home-page ">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=785123928176736&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


@if(Session::has('global'))
	<p>{{Session::has('global')}}</p>
@endif

<div id="container">
  <header id="headerContainer" class="section">
    <div id="accountContainer" class="section">  
      <div class="container">
        <ul class="menu">

	
         @if(Auth::check())
			@if (Auth::user()->isAdmin())
			<li><a href="{{URL::ROUTE('admin')}}">Admin</a></li>
			@endif
	<li><a href="{{URL::ROUTE('myprofile')}}">My Profile</a></li>
	<li><a href="{{URL::ROUTE('submit-politician')}}">Submit A Politician</a></li>
	 <li><a id="sign-out" href="{{URL::ROUTE('signout')}}">Sign Out</a></li>
         @else
          <li><a href="{{URL::ROUTE('login')}}">Log in</a></li>
          <li><a href="{{URL::ROUTE('create-get-1')}}">Sign Up</a></li>
         @endif
          <li><a href="">Help</a></li>
        </ul>
      </div>
    </div>
    <div id="header" class="container">
        
        <div class="row">
          <div class="col-sm-2">
		<div style="float:left;margin-top: 10px;margin-left: 13px;">
		<canvas id="can" width="50" height="50" /></canvas>

		<script>
		var canvas = document.getElementById("can");
		var context = canvas.getContext("2d");
		var lastend = 0;
		var rep_color = '#bf0404';
		var dem_color = '#065eb7';
		var ind_color = '#ebe2c3';
		var rep_data = {{Politician::where('party','=','Republican')->count()}};
		var dem_data ={{Politician::where('party','=','Democrat')->count()}};
		var ind_data = {{Politician::where('party','!=','Democrat')->where('party','!=','Republican')->count()}};
		var data = [ind_data,rep_data,dem_data ];
		var myTotal = 0;
		var myColor = [ind_color,rep_color,dem_color];

		for(var e = 0; e < data.length; e++)
		{
		  myTotal += data[e];
		}

		for (var i = 0; i < data.length; i++) {
		context.fillStyle = myColor[i];
		context.beginPath();
		context.moveTo(canvas.width/2,canvas.height/2);
		context.arc(canvas.width/2,canvas.height/2,23,lastend,lastend+(Math.PI*2*(data[i]/myTotal)),false);
		context.lineTo(canvas.width/2,canvas.height/2);
		context.fill();
		context.lineWidth = 2;
		context.stroke();
		lastend += Math.PI*2*(data[i]/myTotal);
		}
		</script>
		</div>
		<div style="float:right;">
            		<a href="{{URL::route('home')}}" title="iRate Politics"><img src="/assets/images/logo2.png" alt="iRate Politics" id="logo" /></a>			
         	</div>
	 </div>
          
          <div class="col-sm-6">
          
            <div id="search">
              <form  id="search-form" class="form-inline" role="form" action="{{URL::route('search')}}" method="post"  enctype="multipart/form-data">
                <div class="form-group">
                  <input type="input" class="form-control input-lg" name="search_term" placeholder="Politician or Issue: barack, boehner, abortion, guns..."/>
                  <span class="sprite search"></span>
                </div>
              </form>
            </div>
          </div>
          
          <div class="col-sm-4">        
            <div id="nav" role="navigation" >
              <div class="mobile-nav"></div>
              
              <ul class="menu">
                <li><a href="{{URL::route('home')}}">Home</a></li>
		@if(Auth::check())
                
		@endif                
		<li><a href="{{URL::route('list-politicians')}}">Rate a Politician</a></li>
                <li><a href="{{URL::route('about')}}">About Us</a></li>
              </ul>
            </div>              
          </div>
        </div>
        
    </div>
  </header>
  
