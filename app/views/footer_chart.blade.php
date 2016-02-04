

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
  					<ul><?php $polls = Poll::all()->take(3);?>
                                           @foreach($polls as $poll)
						<?php $question = $poll->questions->first();?>
                                            <li><a href="{{URL::route('question',$question->id)}}">{{$question->content}}</a></li>
                                           @endforeach
  					 </ul>
  
  				</div><!-- #second .footer-col -->
  
  				<div id="third" class="col-sm-4">
            <h3>Quick Links</h3>
            <div class="row">
              
              <div class="col-sm-6">
                <ul>
                  <li><a href="{{URL::route('about')}}">About iRate Politics</a></li>
		@if(!(Auth::check()))
                <li><a href="{{URL::route('create')}}">Create Your Profile</a></li>
		@endif                   

		
                  <li><a href="{{URL::route('list-politicians')}}">Rate a Politician</a></li>
                  <li><a href="{{URL::ROUTE('most-popular')}}">Most Popular Politicians</a></li>
		 <li><a href="{{URL::route('least-popular')}}">Least Popular Politicians</a></li>
                </ul>
              </div>
              <div class="col-sm-6">
                <ul>
                  <li><a href="">The Latest News</a></li>
                  <li><a href="">Get Help</a></li>
                  <li><a href="{{URL::route('contact')}}">Contact Us</a></li>
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
              	Site design by <a href="http://www.smackhappydesign.com" >Smack Happy Design</a>/ developed by <a href="http://www.netintelpro.com">NetIntelPro</a>
              </div>
            </div>
            
            <div class="col-sm-6">          
              <div class="informed">
                <a href="http://iratepolitics.com/" title="Home"><img src="/assets/images/icons/home.png" alt="Home"/></a>
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

 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

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

<script type="text/javascript" src="/assets/js/scripts.js"></script>
<script type="text/javascript" src="/assets/js/vote-script.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>


@if($chart)

<script type="text/javascript">

        jQuery(function () {
        jQuery('.chart').highcharts({




	     		  rangeSelector: {
		buttonSpacing: 2,
		inputEnabled: true,
                allButtonsEnabled: true,
		enabled:true,
                buttons: [	
				{
					type: 'day',
					count: 1,
					text: '1d'
				},
							
				{
					type: 'day',
					count: 7,
					text: '7d'
				}, {
					type: 'day',
					count: 30,
					text: '30d'
				}, {
					type: 'month',
					count: 6,
					text: '6m'
				}, {
					type: 'ytd',
					text: 'YTD'
				}, {
					type: 'year',
					count: 1,
					text: '1y'
				}, {
					type: 'all',
					text: 'All'
				}],
                selected: 2
            },
            chart: {
                type: 'line',
                backgroundColor:'rgba(255, 255, 255, 0.1)'
            },
            title: {
                text: 'Approval Over the Last 7 Days',
                x: -20 //center
            },
            xAxis: {
                categories: ['-6', '-5', '-4', '-3', '-2','-1','0']
            },
            yAxis: {
                title: {
                    text: 'Rating'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '°C'
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Democrats',
                color: '#065eb7',
                data: [@if($democrat_chart_data != null)
			@foreach($democrat_chart_data as $data)
				{{trim($data)}},
			@endforeach 
		       @endif]
            }, {
                name: 'Republicans',
                color: '#bf0404',
                data: [@if($republican_chart_data != null)
			@foreach($republican_chart_data as $data)
				{{trim($data)}},
			@endforeach 
		       @endif]
            }]
        });
    });

</script>
@endif

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

	{{$issue_tag_cloud}}
      );
      $(function() {
        // When DOM is ready, select the container element and call the jQCloud method, passing the array of words as the first argument.
        $("#word-cloud").jQCloud(word_list);
      });

		</script>
</body>
</html>
