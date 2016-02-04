@include('header')
<style type="text/css">
a{text-decoration:underline;}
#results{padding-top: 0px !important;margin-top: -36px;}
.create-issue-btn {
margin-top: 69px !important;
margin-bottom: 23px;
}
td{border: 1px solid #ddd;}
</style>
<section id="pageContainer" class="section">
	<div class="container">
<br>
		<section   id="results">
					<h1  style="margin-top:40px;">Searches</h1>
			<div class="table-responsive">
				{{ $searches->links() }}
				
				
				<table id="issue-edit-table" class="table">
					<thead>
						 <tr style="border:1px;border-color:black;">
						    <th>Id</th>
						    <th>Search Term</th>
					            <th>Found</th>
						    <th>Search By</th>
						    <th>Date</th>
						   				    
						   </tr>
						</thead>
						<tbody>
						@foreach ($searches as $search) 

						<tr>
						    <td>{{$search->id}}</td>
						    <td><a href="{{URL::route('search-url',$search->search_term)}}" >{{$search->search_term}}</a></td>
						    <td>@if($search->found)Yes @else No @endif
						    <td><a href="{{URL::route('profile-user',User::find($search->user_id)->username)}}">{{User::find($search->user_id)->username}}</a></td>
   						    <td>{{$search->created_at}}</td>
   						</tr>
			    
						@endforeach
						</tbody>
				</table>
			{{ $searches->links() }}
			</div>
		</section>   
	</div>
</section><!-- #pageContainer -->


@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
