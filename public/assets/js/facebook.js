function irateCall(fb_user)//handles the ajax request and returns json response from server
{
		var url = "http://"+document.domain+"/fb-connect";
		var param = {"fb_user":fb_user}
		var response;
		$.ajax({url:url,data : param,type: "POST",async:false,cache:false,dataType:"json",success:
			function(data){response = data;}});
		return response;
}

function iRateConnect() 
{
	FB.api('/me', function(response) 
		{
		  	var response= irateCall(response);
		  	if (response.status =="logging")
				window.location = "http://"+document.domain+"/myprofile";
			else if (response.status =="registering")
				window.location = "http://"+document.domain+"/create-2";
			console.log('response'+response.status);	
	    	});	  	
}

function statusChangeCallback(response) 
{
    if (response.status === 'connected') 
    {
	iRateConnect();
    } 
    else if (response.status === 'not_authorized') 
    {
      // The person is logged into Facebook, but not your app.

    } 
    else 
    {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
  
    }
}

// This function is called when someone finishes with the Login Button. 
function checkLoginState() 
{
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
}

window.fbAsyncInit = function() 
  {
	  var fb_stat = $("#fb_stat").val();
	  if (fb_stat =="logout")
	  { 
		FB.getLoginStatus(function(response){ 
			if (response.status === 'connected') 
    			{FB.logout(function(response) {document.location.reload();});}});
    	  }else{
	  
	   FB.getLoginStatus(function(response) {
	  statusChangeCallback(response);
	  });}
  };
