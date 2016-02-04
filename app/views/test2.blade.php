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
<title>iRate Politics</title>
	

<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-tour.min.css">
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/star-rating.css.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/star-rating.min.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/style.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/politicians.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/profile.css.css" />
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/search.css.css" />
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



<div id="container">
  <header id="headerContainer" class="section">
    <div id="accountContainer" class="section">  
      <div class="container">
        <ul class="menu">
         	<li><a href="http://ec2-54-191-15-158.us-west-2.compute.amazonaws.com/myprofile">My Profile</a></li>
		
	 <li><a id="sign-out" href="http://ec2-54-191-15-158.us-west-2.compute.amazonaws.com/signout">Sign Out</a></li>
                   <li><a href="">Help</a></li>
        </ul>
      </div>
    </div>
    <div id="header" class="container">
        
        <div class="row">
          <div class="col-sm-2">
            <a href="http://ec2-54-191-15-158.us-west-2.compute.amazonaws.com" title="iRate Politics"><img src="/assets/images/logo.png" alt="iRate Politics" id="logo" /></a>			
          </div>
          
          <div class="col-sm-6">
          
            <div id="search">
              <form class="form-inline" role="form" action="http://ec2-54-191-15-158.us-west-2.compute.amazonaws.com/search" method="post"  enctype="multipart/form-data">
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
                <li><a href="http://ec2-54-191-15-158.us-west-2.compute.amazonaws.com">Home</a></li>
		                
		                
		<li><a href="http://ec2-54-191-15-158.us-west-2.compute.amazonaws.com/politicians">Rate a Politician</a></li>
                <li><a href="http://ec2-54-191-15-158.us-west-2.compute.amazonaws.com/about">About Us</a></li>
              </ul>
            </div>              
          </div>
        </div>
        
    </div>
  </header>
  
	<section id="pageContainer" class="section">
		<section id="results">
			<div class="container">
				<h1 style="margin-up:-20px;">Sign Up: Step 2</h1>
			        <div class="row">
            				<div id="col-left" style="margin-up:-20px;" class="col-md-5">
					
						<h3>Upload a Photo</h3>
					    		<img src="/assets/images/avatars/me-avatar.jpg" class="img-circle img-responsive" alt="">

							<input type="file" name="photo">
						</div>	
						
            				
            			        <div id="col-right" class="col-md-6 col-md-offset-1">
              					<form action="http://ec2-54-191-15-158.us-west-2.compute.amazonaws.com/create-2" method="post" class="form" enctype="multipart/form-data" role="form">
							<div class="row">
							    <div class="col-xs-6 col-md-6">
								<input class="form-control" name="firstname" placeholder="First Name" type="text"
								    required 
								|			
								autofocus />
							    </div>
							    <div class="col-xs-6 col-md-6">
								<input class="form-control" name="lastname" placeholder="Last Name" type="text" required 
								|/>
							    </div>
							</div>
							
							<select class="form-control" name="party">
							    <option value="party">Party Affiliation (optional)</option>
							    <option>Democrat</option>
							    <option>Republican</option>
							    <option>Independant</option>
							</select>
				
							<label for="">
							    Birth Date</label>
							<div class="row">
							    <div class="col-xs-4 col-md-4">
								<select class="form-control" name="birth_month">
								    <option value="00">Month</option>
								     <option value="01">January</option>
								    <option value="02">February</option>
								    <option value="03">March</option>
								    <option value="04">April</option>
								    <option value="05">May</option>
								    <option value="06">June</option>
								    <option value="07">July</option>
								    <option value="08">August</option>
								    <option value="09">September</option>
								    <option value="10">October</option>
								    <option value="11">November</option>
								    <option value="12">December</option>
								</select>
						
							    </div>
							    <div class="col-xs-4 col-md-4">
								<select class="form-control" name="birth_day">
								    <option value="Day">Day</option>
								    									<option value="0">0</option>
								    									<option value="1">1</option>
								    									<option value="2">2</option>
								    									<option value="3">3</option>
								    									<option value="4">4</option>
								    									<option value="5">5</option>
								    									<option value="6">6</option>
								    									<option value="7">7</option>
								    									<option value="8">8</option>
								    									<option value="9">9</option>
								    									<option value="10">10</option>
								    									<option value="11">11</option>
								    									<option value="12">12</option>
								    									<option value="13">13</option>
								    									<option value="14">14</option>
								    									<option value="15">15</option>
								    									<option value="16">16</option>
								    									<option value="17">17</option>
								    									<option value="18">18</option>
								    									<option value="19">19</option>
								    									<option value="20">20</option>
								    									<option value="21">21</option>
								    									<option value="22">22</option>
								    									<option value="23">23</option>
								    									<option value="24">24</option>
								    									<option value="25">25</option>
								    									<option value="26">26</option>
								    									<option value="27">27</option>
								    									<option value="28">28</option>
								    									<option value="29">29</option>
								    									<option value="30">30</option>
								    									<option value="31">31</option>
								    								</select>
							    </div>
							    <div class="col-xs-4 col-md-4">
								<select class="form-control" name="birth_year">
								    	<option value="Year">Year</option>
								     											  
										 	<option value="2004">2004</option>
										  
										 	<option value="2003">2003</option>
										  
										 	<option value="2002">2002</option>
										  
										 	<option value="2001">2001</option>
										  
										 	<option value="2000">2000</option>
										  
										 	<option value="1999">1999</option>
										  
										 	<option value="1998">1998</option>
										  
										 	<option value="1997">1997</option>
										  
										 	<option value="1996">1996</option>
										  
										 	<option value="1995">1995</option>
										  
										 	<option value="1994">1994</option>
										  
										 	<option value="1993">1993</option>
										  
										 	<option value="1992">1992</option>
										  
										 	<option value="1991">1991</option>
										  
										 	<option value="1990">1990</option>
										  
										 	<option value="1989">1989</option>
										  
										 	<option value="1988">1988</option>
										  
										 	<option value="1987">1987</option>
										  
										 	<option value="1986">1986</option>
										  
										 	<option value="1985">1985</option>
										  
										 	<option value="1984">1984</option>
										  
										 	<option value="1983">1983</option>
										  
										 	<option value="1982">1982</option>
										  
										 	<option value="1981">1981</option>
										  
										 	<option value="1980">1980</option>
										  
										 	<option value="1979">1979</option>
										  
										 	<option value="1978">1978</option>
										  
										 	<option value="1977">1977</option>
										  
										 	<option value="1976">1976</option>
										  
										 	<option value="1975">1975</option>
										  
										 	<option value="1974">1974</option>
										  
										 	<option value="1973">1973</option>
										  
										 	<option value="1972">1972</option>
										  
										 	<option value="1971">1971</option>
										  
										 	<option value="1970">1970</option>
										  
										 	<option value="1969">1969</option>
										  
										 	<option value="1968">1968</option>
										  
										 	<option value="1967">1967</option>
										  
										 	<option value="1966">1966</option>
										  
										 	<option value="1965">1965</option>
										  
										 	<option value="1964">1964</option>
										  
										 	<option value="1963">1963</option>
										  
										 	<option value="1962">1962</option>
										  
										 	<option value="1961">1961</option>
										  
										 	<option value="1960">1960</option>
										  
										 	<option value="1959">1959</option>
										  
										 	<option value="1958">1958</option>
										  
										 	<option value="1957">1957</option>
										  
										 	<option value="1956">1956</option>
										  
										 	<option value="1955">1955</option>
										  
										 	<option value="1954">1954</option>
										  
										 	<option value="1953">1953</option>
										  
										 	<option value="1952">1952</option>
										  
										 	<option value="1951">1951</option>
										  
										 	<option value="1950">1950</option>
										  
										 	<option value="1949">1949</option>
										  
										 	<option value="1948">1948</option>
										  
										 	<option value="1947">1947</option>
										  
										 	<option value="1946">1946</option>
										  
										 	<option value="1945">1945</option>
										  
										 	<option value="1944">1944</option>
										  
										 	<option value="1943">1943</option>
										  
										 	<option value="1942">1942</option>
										  
										 	<option value="1941">1941</option>
										  
										 	<option value="1940">1940</option>
										  
										 	<option value="1939">1939</option>
										  
										 	<option value="1938">1938</option>
										  
										 	<option value="1937">1937</option>
										  
										 	<option value="1936">1936</option>
										  
										 	<option value="1935">1935</option>
										  
										 	<option value="1934">1934</option>
										  
										 	<option value="1933">1933</option>
										  
										 	<option value="1932">1932</option>
										  
										 	<option value="1931">1931</option>
										  
										 	<option value="1930">1930</option>
										  
										 	<option value="1929">1929</option>
										  
										 	<option value="1928">1928</option>
										  
										 	<option value="1927">1927</option>
										  
										 	<option value="1926">1926</option>
										  
										 	<option value="1925">1925</option>
										  
										 	<option value="1924">1924</option>
										  
										 	<option value="1923">1923</option>
										  
										 	<option value="1922">1922</option>
										  
										 	<option value="1921">1921</option>
										  
										 	<option value="1920">1920</option>
										  
										 	<option value="1919">1919</option>
										  
										 	<option value="1918">1918</option>
										  
										 	<option value="1917">1917</option>
										  
										 	<option value="1916">1916</option>
										  
										 	<option value="1915">1915</option>
										  
										 	<option value="1914">1914</option>
										  
										 	<option value="1913">1913</option>
										  
										 	<option value="1912">1912</option>
										  
										 	<option value="1911">1911</option>
										  
										 	<option value="1910">1910</option>
										  
										 	<option value="1909">1909</option>
										  
										 	<option value="1908">1908</option>
										  
										 	<option value="1907">1907</option>
										  
										 	<option value="1906">1906</option>
										  
										 	<option value="1905">1905</option>
										  
										 	<option value="1904">1904</option>
										  
										 	<option value="1903">1903</option>
										  
										 	<option value="1902">1902</option>
										  
										 	<option value="1901">1901</option>
										  
										 	<option value="1900">1900</option>
										  
										 	<option value="1899">1899</option>
										  
										 	<option value="1898">1898</option>
										  
										 	<option value="1897">1897</option>
										  
										 	<option value="1896">1896</option>
										  
										 	<option value="1895">1895</option>
										  
										 	<option value="1894">1894</option>
										              	
								</select>
							    </div>
							</div>
							<label class="radio-inline">
							    <input type="radio" name="sex" id="sex" value="male" />
							    Male
							</label>
							<label class="radio-inline">
							    <input type="radio" name="sex" id="sex" value="female" />
							    Female
							</label>

							<textarea type="text"placeholder="More about me..." class="form-control" id="bio" name="bio"  style="height: 50px;"></textarea>
							<h3>Upload a Photo</h3>
							 
							<input type="file" name="photo" id="photo">
							<div class="topics">
								<h3>Issues I Care About</h3>
							   											<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Obamacare</button>
									      <input type="checkbox" class="hidden" name ="1" value="1"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">UN Rights</button>
									      <input type="checkbox" class="hidden" name ="2" value="2"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Syrian Peace Talks</button>
									      <input type="checkbox" class="hidden" name ="3" value="3"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Global Warming</button>
									      <input type="checkbox" class="hidden" name ="4" value="4"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Fuel Efficiency Stan</button>
									      <input type="checkbox" class="hidden" name ="5" value="5"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Obama Stimulus</button>
									      <input type="checkbox" class="hidden" name ="6" value="6"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">California Drought</button>
									      <input type="checkbox" class="hidden" name ="7" value="7"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Minimum Wage</button>
									      <input type="checkbox" class="hidden" name ="8" value="8"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Affirmative Action</button>
									      <input type="checkbox" class="hidden" name ="9" value="9"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Abortion</button>
									      <input type="checkbox" class="hidden" name ="10" value="10"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Education</button>
									      <input type="checkbox" class="hidden" name ="11" value="11"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Budget</button>
									      <input type="checkbox" class="hidden" name ="12" value="12"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Energy</button>
									      <input type="checkbox" class="hidden" name ="13" value="13"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Crime</button>
									      <input type="checkbox" class="hidden" name ="14" value="14"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Environment</button>
									      <input type="checkbox" class="hidden" name ="15" value="15"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Foreign Affairs And </button>
									      <input type="checkbox" class="hidden" name ="16" value="16"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Healthcare</button>
									      <input type="checkbox" class="hidden" name ="17" value="17"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Legalization Of Drug</button>
									      <input type="checkbox" class="hidden" name ="18" value="18"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Immigration</button>
									      <input type="checkbox" class="hidden" name ="19" value="19"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Civil Rights</button>
									      <input type="checkbox" class="hidden" name ="20" value="20"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Social Security</button>
									      <input type="checkbox" class="hidden" name ="21" value="21"/>
									</span>
																		<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">Guns</button>
									      <input type="checkbox" class="hidden" name ="22" value="22"/>
									</span>
																</div>
							<button class="btn btn-lg btn-block light" type="submit">Finish</button>
						</form>
            				</div>
        			</div>
			</div>			
  		</section>
	</section><!-- #pageContainer -->
<footer id="footerContainer" class="section" role="contentinfo">

			<div class="container" role="complementary">
			  
			  <div class="more-buttons">
  			  <a href="" class="btn btn-lg">More Opinions</a>
  			  <a href="" class="btn btn-lg">More News</a>
			  </div>
			  			  
        <div class="row">
        
  				<div id="first" class="col-sm-4">
  
  						<h3>About iRate Politics</h3>			
  						<p>iRate Politics will change politics as we know it by restoring the democracy, and put the power back into the hands of the people.  It is the first website to give Americans a fun, yet influential, and addicting, yet satisfying, way to be active in their government and really make a difference.  
  <a href="/about/">More &raquo;</a></p>
  					
  					  
  				</div><!-- #first .footer-col -->
  
  				<div id="second" class="col-sm-4">
  					<h3>Latest Polls</h3>			
  					<ul>
  					  <li><a href="">The President of the United States wears many hats. Who do you think would make a better leader for conducting the U.S.’s foreign affairs for the next four years?</a></li>
  					  <li><a href="">What is the likelihood that you will actually go out to vote this Nov. 6th 2012?</a></li>
  					  <li><a href="">What do you think is the best way to fight rising gasoline prices?</a></li>
  					</ul>
  
  				</div><!-- #second .footer-col -->
  
  				<div id="third" class="col-sm-4">
            <h3>Quick Links</h3>
            <div class="row">
              
               <div class="col-sm-6">
                <ul>
                  <li><a href="http://ec2-54-191-15-158.us-west-2.compute.amazonaws.com/about">About iRate Politics</a></li>
		                   

		
                  <li><a href="http://ec2-54-191-15-158.us-west-2.compute.amazonaws.com/politicians">Rate a Politician</a></li>
                  <li><a href="http://ec2-54-191-15-158.us-west-2.compute.amazonaws.com/most-popular">Most Popular Politicians</a></li>
		  <li><a href="http://ec2-54-191-15-158.us-west-2.compute.amazonaws.com/least-popular">Least Popular Politicians</a></li>
                </ul>
              </div>
              <div class="col-sm-6">
                <ul>
                  <li><a href="">The Latest News</a></li>
                  <li><a href="">Get Help</a></li>
                  <li><a href="">Contact Us</a></li>
                </ul>
              </div>
              
            </div>
  				</div><!-- #third .footer-col -->

        </div>
			</div><!-- .container -->
	
      
      <div id="bottom" class="section">
        <div class="container">
          
          <div class="row">
            <div class="col-sm-6">      
              <div class="copyright">
                  &copy; 2014 iRate Politics All rights reserved
              </div>
              <div class="credit">
              	Site design by <a href="http://www.smackhappydesign.com" >Smack Happy Design</a>
              </div>
            </div>
            
            <div class="col-sm-6">          
              <div class="informed">
                <a href="http://irate.smackhappy.com/" title="Home"><img src="/assets/images/icons/home.png" alt="Home"/></a>
                <a href="http://www.facebook.com/iratepolitics?skip_nax_wizard=true" title="Facebook"><img src="/assets/images/icons/facebook.png" alt="Facebook"/></a>
                <a href="https://twitter.com/IRatePolitics" title="Twitter"><img src="/assets/images/icons/twitter.png" alt="Twitter"/></a>
                <a href="http://iratepolitics.com/#" title="YouTube"><img src="/assets/images/icons/youtube.png" alt="YouTube"/></a>
                <a href="http://iratepolitics.com/#" title="Vimeo"><img src="/assets/images/icons/vimeo.png" alt="Vimeo"/></a>
                <a href="http://iratepolitics.com/#" title="MySpace"><img src="/assets/images/icons/myspace.png" alt="MySpace"/></a>
                <a href="https://plus.google.com/u/0/b/112038744459040539161/112038744459040539161/posts" title="Google+"><img src="/assets/images/icons/google.png" alt="Google+"/></a>
                <a href="" title="Email"><img src="/assets/images/icons/email.png" alt="Email"/></a>
              </div>					
                   
            </div>
          </div>
                    
        </div>
      </div>
	</footer>

</div><!-- #container -->
<script type="text/javascript" src="/assets/js/vote-script.js"></script>


<script type="text/javascript" src="/assets/js/jquery.js"></script>

<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap-tour.min.js"></script>
<script src="/assets/fancybox/jquery.fancybox.js"></script>
<script src="/assets/fancybox/helpers/jquery.fancybox-buttons.js"></script>
<script src="/assets/fancybox/helpers/jquery.fancybox-thumbs.js"></script>
<link rel="stylesheet" href="/assets/fancybox/helpers/jquery.fancybox-buttons.css">
<link rel="stylesheet" href="/assets/fancybox/helpers/jquery.fancybox-thumbs.css">
<link rel="stylesheet" href="/assets/fancybox/jquery.fancybox.css">

<script type="text/javascript" src="/assets/js/star-rating.min.js"></script>
<script type="text/javascript" src="/assets/js/jqcloud-1.0.4.min.js"></script>

<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="/assets/js/charts/highcharts.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
<script type="text/javascript" src="/assets/js/scripts.js"></script>



 <script type="text/javascript">
        // Instance the tour
        // http://bootstraptour.com/
        var tour = new Tour({
          steps: [
          {
            element: "#search",
            title: "Search",
            content: "Search politicians by name or issue.",
            placement: "bottom"
          },
          {
            element: "#obama .vote",
            title: "Vote",
            content: "Vote for your politician based on how they handle an issue."
          },
          {
            element: "#create-profile",
            title: "Make a Difference",
            content: "Watch your politician's ratings move in real-time and build your reputation as the most active citizen in your community.",
            placement: "left"
          },
          {
            element: "#obama",
            title: "Remember:",
            content: '<p>In a democracy, the power is in the hands of the people!</p> <p><a href="/policitican/" class="btn">Start by voting on the President</a></p>'
          }
        ]});
        
        // Initialize the tour
        tour.init();
        
        // Start the tour
        tour.start();
        
      var word_list = new Array(
        	null
      );
      $(function() {
        // When DOM is ready, select the container element and call the jQCloud method, passing the array of words as the first argument.
        $("#word-cloud").jQCloud(word_list);
      });

		</script>
</body>
</html>

