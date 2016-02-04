@include('header')
<style type="text/css">
a{text-decoration:underline;}
#results{padding-top: 0px !important;margin-top: -36px;}
.create-politician-btn {
margin-top: 69px !important;
margin-bottom: 23px;
}
</style>
<section id="pageContainer" class="section">
	<div class="container">
		<section id="results">
			@if(Auth::user()->isAdmin())
			<div class ="row" style="text-align:center;">
				<div >
					<a href="{{URL::route('create-politician')}}" class="btn btn-lg create-politician-btn" id="new-politician">Submit New Politician</a>
				</div>
			</div>
			@endif

			<div class="table-responsive">
				{{ $politicians->links() }}
				
				
				<table class="table">
					<thead>
						 <tr style="border:1px;border-color:black;">
						    <th>Id</th>
						    <th>Full Name</th>
						    <th>Office</th>
						    <th>District</th>
						    <th>Party</th>
						    <th>City</th>
						    <th>State</th>
						    <th>Sex</th>
						   </tr>
						</thead>
						<tbody>
						@foreach ($politicians as $politician) 

						<tr>
						    <td>{{$politician->id}}</td>
						    <td>
							<a href="{{URL::route('edit-politician',$politician->full_name)}}" >
								{{$politician->full_name}}
							</a>
						    </td>
						    <td><a href="{{URL::route('edit-politician',$politician->full_name)}}" >{{$politician->office}}</a></td>
						    <td><a href="{{URL::route('edit-politician',$politician->full_name)}}" >{{$politician->district}}</a></td>
						    <td><a href="{{URL::route('edit-politician',$politician->full_name)}}" >{{$politician->party}}</a></td>
						    <td><a href="{{URL::route('edit-politician',$politician->full_name)}}" >{{$politician->city}}</a></td>
						    <td><a href="{{URL::route('edit-politician',$politician->full_name)}}" >{{$politician->state}}</a></td>
						    <td><a href="{{URL::route('edit-politician',$politician->full_name)}}" >{{$politician->sex}}</a></td>
						  </tr>
			  

			  
			   
						@endforeach
						</tbody>
				</table>
			{{ $politicians->links() }}
			</div>
		</section>   
	</div>
</section><!-- #pageContainer -->
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
