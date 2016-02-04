$( ".search" ).click(function() {
  $( "#search-form" ).submit();
});

$( "#auto-politician" ).autocomplete({

      source: function( request, response ) {
        console.log('alert');
	var url = "http://"+document.domain+"/auto-politician";
	var term = $("#auto-politician").val();
	var param = {"term":term};
        $.ajax({
		url:url,
		data : param,
		type: "POST",
		async:false,
		cache:false,
		dataType:"json",
		success: function(data){response( data );}
		});
	
      }	,
	minLength: 3
    
    });
  

$("#edit-poll").on("click",".add-new-answer", function(e){e.preventDefault();
	var question_id = $( this ).attr('href');

	$("#answer-col-"+question_id).append('<div class="row"><div class="answer-form-group">'+					
'<input class="form-control" style="width:75%;float:left;" value="" id="new_poll_answers-'
+question_id+'" name="new_poll_answers-'+question_id+'[]"'+
' placeholder="New Answer" type="text"><a style="padding: 10px;float:right;"class="remove_answer_field">Remove</a></div></div>');
});

$(".input_fields_wrap").on("click",".remove_field", function(e){ //user click on remove text
	var question_id = $( this ).attr('href');
	
	makeCall("http://"+document.domain+"/delete-question",{"question_id":question_id});
        e.preventDefault(); $(this).parent('div').remove(); 
    });

$(".input_fields_wrap").on("click",".remove_answer_field", function(e){ //user click on remove text
	var answer_id = $( this ).attr('href');
	
	makeCall("http://"+document.domain+"/delete-answer",{"answer_id":answer_id});
        e.preventDefault(); $(this).parent('div').remove(); 
    });


$("#add-new-answer-btn").bind('click',function()
{
$(".input_fields_wrap").append('<div class="row"><div class="form-group"><label class="pull-left">Poll Question</label>'+					
'<input class="form-control" style="width:90%;float:left;" value="" id="poll_questions" name="new_poll_questions[]"'+
' placeholder="New Question" type="text"><a style="padding: 10px;float:right;"class="remove_field">Remove</a></div></div>');


});

$("#poll-delete").bind('click', function()
{

	$( "div.modal-content" ).html( '<div class="modal-header"><button type="button" class="close"'+
	'data-dismiss="modal" aria-hidden="true">&times;</button>'+
	'<h4 class="modal-title" id="myModalLabel">This Poll Has Been Deleted</h4></div><div class="modal-body">'+
	'</div><div class="modal-footer"></div>' ).delay( 20000 );
	var poll_id = $("#poll_id").val();

	makeCall("http://"+document.domain+"/delete-poll",{"poll_id":poll_id});
	window.location = "http://"+document.domain+"/admin/polls";

});


$("#poll-delete-button").bind('click', function()
{
	var poll_id = $("#delete-poll-id").val();
	var title = $("#delete-poll-title").val();
	$( "div.modal-content" ).html( '<div class="modal-header"><button type="button" class="close"'+
	'data-dismiss="modal" aria-hidden="true">&times;</button>'+
	'<h4 class="modal-question" id="myModalLabel">'+title+' Has Been Deleted</h4></div><div class="modal-body">'+
	'</div><div class="modal-footer"></div>' ).delay( 20000 );
	console.log('poll id: '+poll_id);

	makeCall("http://"+document.domain+"/delete-poll",{"poll_id":poll_id});
	

});

$("#comment-delete-button").bind('click', function()
{
	var comment_id = $("#delete-comment-id").val();
	var comment_content = $("#delete-comment-span").html();
	$( "div.modal-content" ).html( '<div class="modal-header"><button type="button" class="close"'+
	'data-dismiss="modal" aria-hidden="true">&times;</button>'+
	'<h4 class="modal-question" id="myModalLabel"><i>'+comment_content+'</i> <br><br>Has Been Deleted And All Replies</h4></div><div class="modal-body">'+
	'</div><div class="modal-footer"></div>' ).delay( 20000 );


	makeCall("http://"+document.domain+"/delete-comment",{"comment_id":comment_id});
	

});


$("#poll-edit-table").on("click",".poll-delete-link", function(event)
{

		var issue_attr = $( this ).attr('href');
		var poll_title = issue_attr.substring(0,issue_attr.indexOf("-"));
		var poll_id = issue_attr.substring(issue_attr.indexOf("-")+1);

		console.log('poll id: '+poll_id);
                $('#delete-poll-title').val(poll_title);
		$('#delete-poll-id').val(poll_id);
		$( "#delete-poll-span" ).html(poll_title);

	});
$("#comment-edit-table").on("click",".comment-delete-link", function(event)
{

		var comment_id = $( this ).attr('href');

		var comment_content = $('#content-'+comment_id).text();


		$('#delete-comment-id').val(comment_id);
		$( "#delete-comment-span" ).html(comment_content);

	});




$("#new-poll-submit").bind('click',function()
{		

		var title = $("#poll_title").val();
		var response = makeCall("http://"+document.domain+"/new-poll",{"title":title});
		
		if (response != null)
			{
				$( "div.modal-content" ).html( '<div class="modal-header"><button type="button" class="close"'+
				'data-dismiss="modal" aria-hidden="true">&times;</button>'+
				'<h4 class="modal-question" id="myModalLabel"><span style="color:red;">'+
				'Error: </span>Poll <b>'+title+'</b> has ALREADY been created here '+
				'<a href="">'+response.title+'</a></h4></div><div class="modal-body">'+
				'</div><div class="modal-footer"></div>' );		
			}							
			
		else   
			{
				$( "div.modal-content" ).html( '<div class="modal-header"><button type="button" class="close"'+
				'data-dismiss="modal" aria-hidden="true">&times;</button>'+
				'<h4 class="modal-question" id="myModalLabel"><span style="color:green;">'+
				'Success: </span>Poll <b>'+title+'</b> has been created here '+
				'<a href="">'+title+'</a></h4></div><div class="modal-body">'+
				'</div><div class="modal-footer"></div>' );		
			}

		//window.location = "http://"+document.domain+"/admin/issues";


});
function getNews(politician_id, issue_id,user_id)
{
	var url = "http://"+document.domain+"/get-news";
	return makeCall(url,{"politician_id": politician_id,"issue_id":issue_id,"user_id":user_id});
}

function getBox(politician_id, issue_id,user_id,next_row_count,issue_name,article_index,type)
{																																																																													
	var response = getNews(politician_id, issue_id,user_id);
	var news = response.news;
	var sum = response.sum;

	var output = "";
	if(type=='row')
		output += '<div class="row" id="issue-row-'+next_row_count+'">';	
	output += '<div class="col-xs-4 issue-box" ><div class="box"><header><h3>'+issue_name+
		  '</h3>';

	
		output += '<form action="http://'+document.domain+'/issue-vote" method="post" class="form"'+
			  ' enctype="multipart/form-data" id="form-issue-vote">'+
			  '<input type="hidden" value="'+politician_id+'" name="'+politician_id+'" id="'+politician_id+'">'+
			  '<input type="hidden" value="'+issue_id+'" name="'+issue_id+'" id="'+issue_id+'">'+  
			  '<input type="hidden" value="'+user_id+'" name="'+user_id+'" id="'+user_id+'">'+      
			  '<input type="hidden" value="'+user_id+'" name="vote" id="vote">'+
			  '<span class="thumbs" id="thumbs'+issue_id+'">'+
			  '<a id="'+politician_id+'-'+issue_id+'" class="sprite thumbs-up';
		if(parseInt(sum) >= 1) output +='-grey ';
		output +=  '"></a><a id="'+politician_id+'-'+issue_id+'" class="sprite thumbs-down'; 
		if(parseInt(sum) <= -1) output +='-grey ';
		
	output += '" ></a></form></header> <div class="description">';		 		
	
	
	for(var i = 0; i < news.length; i++) {
    		var article = news[i];
		if(article != null){
			output += '<div><p><a onclick="readNews('+article_index+');">'+article.title+'</a> <br>'+
			       '<span class="date">'+article.publishedDate+'</span></p><p class="news_content"'+
			       'id="news_content'+article_index+'">'+article.content+
			       '<a target="_blank" href="http://'+document.domain+'/article?url='+article.unescapedUrl;
			try{       
				if (article.image.url !== 'undefined')	
				{		
					output += '&pic='+article.image.url;

				}
			}catch(err) {

			    }

			output += '&summary='+article.content+'"><i>continued</i></a></p><br/></div>';
			article_index++; 
		}
	}
	output += 	'</div></div></div>';
	if(type=='row')output += '</div>';
	$("#article_index").val(article_index);	
	return output;																																																																
}

$(".btn-issue a").click(function(){
	$(this).fadeOut();

	var issue_attr = $( this ).attr('id');
	var politician_id = issue_attr.substring(0,issue_attr.indexOf("-"));
	var issue_id = issue_attr.substring(issue_attr.indexOf("-")+1);	
	var user_id = $("#user").val();
	var issue_name = $(this).html();
	var issue_count = $("#issue_count").val();
	var article_index = $("#article_index").val();
	
	if ((issue_count%3)==0)
	{
		var next_row_count = (parseInt(issue_count)/3)+1;
		var row = getBox(politician_id, issue_id,user_id,next_row_count,issue_name,article_index,'row');
		$("#issues-rows").append(row);
		$("#issue_count").val(++issue_count);
	}
	else 
	    {	
		var box = getBox(politician_id, issue_id,user_id,next_row_count,issue_name,article_index,'box');
		if ((issue_count%3)==1)
			var row_count = (parseInt(issue_count)+2)/3;
		else var row_count =	(parseInt(issue_count)+1)/3;
		$("#issue-row-"+row_count).append(box);
		$("#issue_count").val(++issue_count);
		
	   }
});


$( "#show-more-issues" ).click(function(){
	$(".btn-issue").toggle();//each(function(i,e) {$(this).delay(i*50).fadeIn();});
		

});


$( ".modal" ).on( "click", "#edit-issue-submit", function( event )
{	


	var issue_name = $("#edit-issue-input").val();
	var issue_id = $("#issue_id").val();
	var response = makeCall("http://"+document.domain+"/update-issue",{"issue_name":issue_name,"issue_id":issue_id});
		if (response != null)
			{
				$( ".modal-title" ).html( '<span style="color:red;">'+
				'Error: </span>Issue <h1>'+response.issue_name+'</h1> ALREADY exists. Try again ');		
			}							
			
		else   
			{
				$( ".modal-title" ).html( '<span style="color:green;">'+
				'Success: </span>Issue <b>'+issue_name+'</b> has been edited' );
			}
});


$( ".modal" ).on( "click", ".cancel", function( event ){	event.preventDefault();document.location.reload();});


$("#issue-edit-table").on("click",".issue-edit-link", function(event)
	{
		//event.preventDefault();
		var issue_attr = $( this ).attr('href');
		var issue_name = issue_attr.substring(0,issue_attr.indexOf("-"));
		var issue_id = issue_attr.substring(issue_attr.indexOf("-")+1);
                $('#edit-issue-input').val(issue_name);
		$('#issue_id').val(issue_id);
	});
$("#issue-edit-table").on("click",".issue-delete-link", function(event)
{

		var issue_attr = $( this ).attr('href');
		var issue_name = issue_attr.substring(0,issue_attr.indexOf("-"));
		var issue_id = issue_attr.substring(issue_attr.indexOf("-")+1);
		$('#delete-issue-name').val(issue_name);
		$('#delete-issue-id').val(issue_id);
		$( "#delete-issue-span" ).html(issue_name);

	});

$("#issue-delete-button").bind('click', function()
{
	var issue_id = $("#delete-issue-id").val();
	var issue_name = $("#delete-issue-name").val();
	$( "div.modal-content" ).html( '<div class="modal-header"><button type="button" class="close"'+
	'data-dismiss="modal" aria-hidden="true">&times;</button>'+
	'<h4 class="modal-title" id="myModalLabel">'+issue_name+' Has Been Deleted</h4></div><div class="modal-body">'+
	'</div><div class="modal-footer"></div>' ).delay( 20000 );
	

	makeCall("http://"+document.domain+"/delete-issue",{"issue_id":issue_id});
	

});

$( ".modal" ).on( "click", ".close", function( event ){	event.preventDefault();document.location.reload();});

$("#issue-delete-cancel").bind('click',function(){window.location = "http://"+document.domain+"/admin/issues";});
$("#new-issue-close").bind('click',function(){window.location = "http://"+document.domain+"/admin/issues";});
$("#new-issue-cancel").bind('click',function(){window.location = "http://"+document.domain+"/admin/issues";});
$("#new-issue-submit").bind('click',function()
{		

		var issue_name = $("#issue_name").val();
		var response = makeCall("http://"+document.domain+"/new-issue",{"issue_name":issue_name});
		//response = JSON.stringify(response);
		//console.log('ajax: '+response);
		if (response != null)
			{
				$( "div.modal-content" ).html( '<div class="modal-header"><button type="button" class="close"'+
				'data-dismiss="modal" aria-hidden="true">&times;</button>'+
				'<h4 class="modal-title" id="myModalLabel"><span style="color:red;">'+
				'Error: </span>Issue <b>'+issue_name+'</b> has ALREADY been created here '+
				'<a href="">'+response.issue_name+'</a></h4></div><div class="modal-body">'+
				'</div><div class="modal-footer"></div>' );		
			}							
			
		else   
			{
				$( "div.modal-content" ).html( '<div class="modal-header"><button type="button" class="close"'+
				'data-dismiss="modal" aria-hidden="true">&times;</button>'+
				'<h4 class="modal-title" id="myModalLabel"><span style="color:green;">'+
				'Success: </span>Issue <b>'+issue_name+'</b> has been created here '+
				'<a href="">'+issue_name+'</a></h4></div><div class="modal-body">'+
				'</div><div class="modal-footer"></div>' );		
			}

		//window.location = "http://"+document.domain+"/admin/issues";


});



$("#user-delete").bind('click', function()
{

	$( "div.modal-content" ).html( '<div class="modal-header"><button type="button" class="close"'+
	'data-dismiss="modal" aria-hidden="true">&times;</button>'+
	'<h4 class="modal-title" id="myModalLabel">This User Has Been Deleted</h4></div><div class="modal-body">'+
	'</div><div class="modal-footer"></div>' ).delay( 20000 );
	var user_id = $("#user_id").val();

	makeCall("http://"+document.domain+"/delete-user",{"user_id":user_id});
	window.location = "http://"+document.domain+"/admin/users";

});

$("#politician-delete").bind('click', function()
{

	$( "div.modal-content" ).html( '<div class="modal-header"><button type="button" class="close"'+
	'data-dismiss="modal" aria-hidden="true">&times;</button>'+
	'<h4 class="modal-title" id="myModalLabel">This Politician Has Been Deleted</h4></div><div class="modal-body">'+
	'</div><div class="modal-footer"></div>' ).delay( 20000 );
	var politician_id = $("#politician_id").val();

	makeCall("http://"+document.domain+"/delete-politician",{"politician_id":politician_id});
	//window.location = "http://"+document.domain+"/admin/politicians";

});



  $("#photo").on("change", function()
    {

        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div

	    if (!($('#imagePreview').hasClass('politician'))) 
			$("#imagePreview").addClass('politician');
            $("#imagePreview").css("background-image", "url("+this.result+")");
	    $("#image_uploaded").val("true");

            }
        }
    });

$("#full_name").on("change", function()
    {
	var fullname = $("#full_name").val();
        var firstname = fullname.substring(0,fullname.indexOf(" "));
	var lastname = fullname.substring(fullname.indexOf(" ")+1);
	$("#first_name").val(firstname);
	$("#last_name").val(lastname);



    });
$( ".list-group" ).on( "click", ".vote-up-sprite", function( event ){	
	 event.preventDefault();
		var id = $(this).attr('id');
		var comment_id = id.substring(id.indexOf("-")+1);
		console.log('comment_id: '+comment_id);
		var rank = makeCall("http://"+document.domain+"/vote-comment",{"value":1,"comment_id":comment_id});
		console.log('rank: '+rank);
		//$('#rankup-'+comment_id).text(rank); - old from when counting up/down votes
		$('#rank-'+comment_id).text(rank); //new displaying rank		

});

$( ".list-group" ).on( "click", ".vote-down-sprite", function( event ){	
	 event.preventDefault();
		var id = $(this).attr('id');
		var comment_id = id.substring(id.indexOf("-")+1);
		console.log('comment_id: '+comment_id);
		var rank = makeCall("http://"+document.domain+"/vote-comment",{"value":-1,"comment_id":comment_id});
		console.log('rank: '+rank);
		//$('#rankdown-'+comment_id).text(rank); - old from when counting up/down votes
		$('#rank-'+comment_id).text(rank); //new displaying rank		
});



$( ".row" ).on( "click", ".reply-comment-button", function( event ){	
	 event.preventDefault();


	var id = $(this).attr('id');
	var parent_id = id.substring(0,id.indexOf("-"));
	var politician_id = id.substring(id.indexOf("-")+1);
	var textarea_id = "#textarea-"+parent_id+"-"+politician_id;

	var content = $(textarea_id).val();

	var comment = submitComment(content,politician_id,parent_id);

	if (parent_id == 0)
		var reply = false;
	else var reply = true;
	$('#list-group-'+parent_id).prepend(writeComment(comment,reply));
	
	//update the reply count
	var count = $('#'+parent_id+'-'+politician_id).text();

	count = count.substring(0,count.indexOf(" "));

	count = parseInt(count);
	count = count +1;

	$('#'+parent_id+'-'+politician_id).text(count+' replies');
	//clear the text area
	$(textarea_id).val("");
	
});

function getUser(user_id)
{		console.log('getUser: user_id '+user_id);
		return makeCall("http://"+document.domain+"/get-user",{"user_id":user_id});
}

function writeComment(comment,reply)
{

	var user = getUser(comment.user_id);
	
	var output = 
       '<li class="list-group-item"><div class="row" id="row-2"><div class="col-sm-2"><a href="http://'+document.domain+'/user/'
	+user.username+'"><img src="'+user.pic_url+'" class="img-circle img-responsive" alt=""></a></div><input type="hidden" value="'+
	comment.id+'" name="comment_id" id="comment_id"><div class="col-sm-10"><div class="mic-info">'+
	'<a href="http://'+document.domain+'/user/'+
	+user.username+'">'+user.username+'</a> <span class="date"> on '+comment.created_at+'</span></div>'+
	'<blockquote class="comment-text">'+comment.content+'</blockquote><div class="row comment-meta"><div class="col-sm-2">'+ 
	'<div class="voting"><a class="vote-up" ><span class="sprite vote-up vote-up-sprite"'+
	'id="up-'+comment.id+'"></span></a><span id="rank-'+comment.id+'">0</span><a class="vote-down" ><span class="sprite vote-down vote-down-sprite" id="down-'+comment.id+
	'"></span></a></div></div></div><div class="col-sm-8">'+
                            '<div class="topics">'+
                             ' <a href="" class="thumbs-down"><span class="sprite thumbs-down"></span> Healthcare</a>'+ 
                              '<a href="" class="thumbs-down"><span class="sprite thumbs-down"></span> Economy</a>'+
                              '<a href="" class="thumbs-down"><span class="sprite thumbs-down"></span> Immigration</a>'+
                            '</div></div>';
	if (!(reply))
		{output = output +'<div class="col-sm-2"><a class="replies pull-right" id="replies-'+comment.id+'">0 replies</a></div>';
		}
	output = output + '</div></div></div></li>';
	return output;
}

function submitComment(content,politician_id,parent_id)
{
 return makeCall("http://"+document.domain+"/submit-comment",{"politician_id":politician_id,"content":content,"parent_id":parent_id});

}




$(".parent-comment-button").bind('click',function()
{
	var id = $(this).attr('id');
	var parent_id = id.substring(0,id.indexOf("-"));
	var politician_id = id.substring(id.indexOf("-")+1);
	var textarea_id = "#textarea-"+parent_id+"-"+politician_id;

	var content = $(textarea_id).val();
	$(textarea_id).val('');
	var comment = submitComment(content,politician_id,parent_id);

	if (parent_id == 0)
		var reply = false;
	else var reply = true;
	$('#list-group-'+parent_id).prepend(writeComment(comment,reply));
});


$(".replies").bind('click', function()
{
	var id = $(this).attr('id');
	var politician_id = id.substring(id.indexOf("-")+1);
	var comment_id = id.substring(0,id.indexOf("-"));	

	if( !($("#reply-"+comment_id).length) )
	{
		
		

		var replies = makeCall("http://"+document.domain+"/get-replies",{"comment_id":comment_id});
		var output = writeReplies(replies,comment_id,politician_id);

		var selector = '#row-'+comment_id;
		$(selector).append(output);	

	}
	else 
		{
			$( "#reply-"+comment_id ).slideToggle( "slow", function() {/*Animation complete*/ });

		}

});


function writeReplies(replies,parent_id,politician_id)
{

	

	var output = '<div id="reply-'+parent_id+'" class= "reply-group" style="width: 85%;float: right;">';
	var output = output + '<div class="form-group"><textarea type="text" class="form-control" id="textarea-'+parent_id+'-'+politician_id+
	'" placeholder="Whats your reply?" style="margin-left:3%;width:97%;height: 50px;">'+
	'</textarea></div><button type="submit" class="btn pull-right reply-comment-button" id="'
	+parent_id+'-'+politician_id+'">Submit</button>'+'<ul class="list-group" id="list-group-'+parent_id+'" style="padding-top: 52px;">';
	for(var i = 0; i < replies.length; i++) {
    		var reply = replies[i];
		
		var user = getUser(reply.user_id);

		
		output = output +
       '<li class="list-group-item" ><div class="row" id="row-2"><div class="col-sm-2"><a href="http://'+document.domain+'/user/'
	+user.username+'"><img src="'+user.pic_url+'" class="img-circle img-responsive" alt=""></a></div><input type="hidden" value="'+
	reply.id+'" name="comment_id" id="comment_id"><div class="col-sm-10"><div class="mic-info">'+
	'<a href="http://'+document.domain+'/user/'+
	+user.username+'">'+user.username+'</a> <span class="date"> on '+reply.created_at+'</span></div>'+
	'<blockquote class="comment-text">'+reply.content+'</blockquote><div class="row comment-meta"><div class="col-sm-2">'+ 
	'<div class="voting"><a class="vote-up" ><span class="sprite vote-up vote-up-sprite"'+
	'id="up-'+reply.id+'"></span></a><span id="rank-'+reply.id+'">'+reply.rank+'</span><a class="vote-down" ><span class="sprite vote-down vote-down-sprite" id="down-'+reply.id+
	'"></span></a></div></div><div class="col-sm-8">'+
                            '<div class="topics">'+
                             ' <a href="" class="thumbs-down"><span class="sprite thumbs-down"></span> Healthcare</a>'+ 
                              '<a href="" class="thumbs-down"><span class="sprite thumbs-down"></span> Economy</a>'+
                              '<a href="" class="thumbs-down"><span class="sprite thumbs-down"></span> Immigration</a>'+
                            '</div></div></div></div></div></li>'



	}
	
	output = output +'</ul></div>';

	return output;
}

$( ".follow" ).bind('click', function() {var id = $(this).attr('id');
 makeCall("http://"+document.domain+"/follow-politician",{"politician_id":id});
 if($.trim($(this).text())== 'FOLLOW')
  	$(this).text('UN-FOLLOW');
   else $(this).text('FOLLOW');


  
});

$( ".user-follow" ).bind('click', function() {var id = $(this).attr('id');
 makeCall("http://"+document.domain+"/follow-user",{"follow_user_id":id});
 if($.trim($(this).text())== 'FOLLOW')
  	$(this).text('UN-FOLLOW');
   else $(this).text('FOLLOW');


  
});


$( ".issue-row" ).on( "click", ".thumbs-up", function( event ){

			event.preventDefault();
			var vote = 1;
			var id = $(this).attr('id');
			var politician_id= id.substring(0,id.indexOf("-"));
			var issue_id= id.substring(id.indexOf("-")+1);
			
			var url = "http://"+document.domain+"/issue-vote";

			var chartData = makeCall(url,{"politician_id": politician_id,"issue_id": issue_id,"vote": vote});

			$('.politicians-chart').highcharts(getChartOptions(chartData));
		//	$('.thumbs'+issue_id).fadeOut('slow'); // fade out the vote buttons
			//$(this).parent().fadeOut('slow'); // fade out the vote buttons
			//$(this).toggleClass( "thumbs-up","slow" );
			if ($(this).siblings().hasClass("thumbs-down-grey"))
				{
					$(this).siblings().toggleClass( "thumbs-down-grey");
					$(this).siblings().toggleClass( "thumbs-down");
				}
			else {$(this).toggleClass( "thumbs-up");$(this).toggleClass( "thumbs-up-grey");}
			console.log('trend: '+chartData.trend);
			var trend = chartData.trend;//this is updated 'rank' from ajax call

			if (trend > 0) 
				$('#trend').addClass('trend-up-stat ').removeClass('trend-down-stat');
			else 	$('#trend').addClass('trend-down-stat ').removeClass('trend-up-stat');
			
			$('#trend').text(trend);

			});
$( ".issue-row" ).on( "click", ".thumbs-down", function( event ){

			event.preventDefault();
			var vote = -1;
			var id = $(this).attr('id');
			var politician_id= id.substring(0,id.indexOf("-"));
			var issue_id= id.substring(id.indexOf("-")+1);
			var url = "http://"+document.domain+"/issue-vote";
			var chartData = makeCall(url,{"politician_id": politician_id,"issue_id": issue_id,"vote": vote});
			//console.log('chartData: '+JSON.stringify(chartData));
			$('.politicians-chart').highcharts(getChartOptions(chartData));
			//	$('.thumbs'+issue_id).fadeOut('slow'); // fade out the vote buttons
			//$(this).parent().fadeOut('slow'); // fade out the vote buttons
			if ($(this).siblings().hasClass("thumbs-up-grey"))
				{
					$(this).siblings().toggleClass( "thumbs-up-grey");
					$(this).siblings().toggleClass( "thumbs-up");
				}
			else {$(this).toggleClass( "thumbs-down");$(this).toggleClass( "thumbs-down-grey");}
			//console.log('trend: '+chartData.trend);
			var trend = chartData.trend;//this is updated 'rank' from ajax call

			if (trend > 0) 
				$('#trend').addClass('trend-up-stat ').removeClass('trend-down-stat');
			else 	$('#trend').addClass('trend-down-stat ').removeClass('trend-up-stat');
			
			$('#trend').text(trend);
			});


function getCommentUsername(user_id)
{
	return makeCall("http://"+document.domain+"/get-username",{"user_id":user_id}).username;
}


function makeCall(url,param)//handles the ajax request and returns json response from server
{
	var response;
	$.ajax({url:url,data : param,type: "POST",async:false,cache:false,dataType:"json",success:
		function(data){
		response = data;
		}
	});
	return response;

}

function getPollChartOptions(chartData){

	var options = {
        chart: {
            type: 'bar'
        },
        title: {
            text: chartData.title
        },
        
        xAxis: {
            categories: chartData.xaxis,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
	    max: 100,
            title: {
                text: '% of Votes',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: '%'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        
        credits: {
            enabled: false
        },
        series: [ {
	    showInLegend: false,
            data: chartData.percentages
        }]
    };
	return options;

}
function getChartOptions(chartData){
	var options = {

		rangeSelector: {
		buttonSpacing: 2,
		inputEnabled: false,
                allButtonsEnabled: true,
		enabled:true,
                buttons: [	
				{
					type: 'hour',
					count: 24,
					text: '24h',
					id:chartData.id
				},
							
				{
					type: 'day',
					count: 7,
					text: '7d',
					id:chartData.id
				}, {
					type: 'day',
					count: 30,
					text: '30d',
					id:chartData.id
				}, {
					type: 'month',
					count: 6,
					text: '6m',
					id:chartData.id
				}, {
					type: 'year',
					count: 1,
					text: '1y',
					id:chartData.id
				}],
                selected: chartData.selected
            },


			chart: {
                		type: 'line',
                		backgroundColor:'rgba(255, 255, 255, 0.1)'
            			},
            		title: {
                		text: chartData.title,
                		x: -20 //center
            			},
            		xAxis: {
				type: 'category',
                		categories: chartData.xaxis,
				events: {
            setExtremes: function(e) {
               // console.log(this);
                if(typeof(e.rangeSelectorButton)!== 'undefined')
                {
                  rangeChart(e.rangeSelectorButton.id,e.rangeSelectorButton.count,e.rangeSelectorButton.text,e.rangeSelectorButton.type);
                }
            }
        }
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
                			data: chartData.democrat_chart_data
            			}, 
				{
                			name: 'Republicans',
                			color: '#bf0404',
                			data: chartData.republican_chart_data
            			},
				{
					name: 'Independents',
                			color: '#af9d54',
                			data: chartData.independent_chart_data
				},
				{
					name: 'Unaffiliated',
                			color: '#0000ff',
                			data: chartData.unaffiliated_chart_data
				}]
        		};//end options
    	return options;
	}// end function




function submitVote(value,index)
{

	$( '#vote' ).val(value);
	$('#thumbs'+index).fadeOut('fast'); // fade out the vote buttons



}
function hideNews(index)
{
	$('#news_content'+index).hide();
}
function readNews(index)
{
	$('#news_content'+index).toggle();
}

function rangeChart(id, count,text,type)
{
			if ($(".users-chart")[0])
				var cat = 'U';
			else 	var cat = 'P';

  			var url = "http://"+document.domain+"/chart-range";
			var chartData = makeCall(url,{"id": id,"range":text,"type":type,"count":count,"cat":cat});
			var selector = '#'+id;
			if(cat=='P')
				$('div'+selector+'.politicians-chart').highcharts(getChartOptions(chartData));
		        else $('div'+selector+'.users-chart').highcharts(getChartOptions(chartData));
}

    
jQuery(document).ready(function() {

	$(".politicians-chart").each( function()
		{

			var politician_id = $( this ).attr('id');
  			var url = "http://"+document.domain+"/politician-chart";
			var chartData = makeCall(url,{"politician_id": politician_id });
			$( this ).highcharts(getChartOptions(chartData));

		});

	$(".users-chart").each( function()
		{

			var user_id = $( this ).attr('id');
  			var url = "http://"+document.domain+"/user-chart";
			var chartData = makeCall(url,{"user_id": user_id });
			$( this ).highcharts(getChartOptions(chartData));

		});
	$(".questions-chart").each( function()
		{

			var question_id = $( this ).attr('id');
  			var url = "http://"+document.domain+"/question-chart";
			var chartData = makeCall(url,{"question_id": question_id });
			$( this ).highcharts(getPollChartOptions(chartData));

		});


});






