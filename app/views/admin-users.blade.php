@include('header')
<style type="text/css">
a{text-decoration:underline;}
#results{padding-top: 0px !important;margin-top: -36px;}
.create-user-btn {
margin-top: 69px !important;
margin-bottom: 23px;
}
td{border: 1px solid #ddd;}
</style>
<section id="pageContainer" class="section">
	<div class="container">
		<section id="results">
			@if(Auth::user()->isAdmin())
			<div class ="row" style="text-align:center;">
				<div >
					<a href="{{URL::route('create-user')}}" class="btn btn-lg create-user-btn" id="new-user">Submit New user</a>
				</div>
			</div>
			@endif

			<div class="table-responsive">
				{{ $users->links() }}
				
				
				<table class="table">
					<thead>
						 <tr style="border:1px;border-color:black;">
						    <th>Id</th>
						    <th>Username</th>
						    <th>First Name</th>
						    <th>Last Name</th>
						    <th>Email</th>
						    <th>City</th>
						    <th>State</th>
						    <th>Sex</th>
						    <th>Age</th>
						    <th>Party</th>
						    <th>Role</th>
						    <th>Created</th>
						    <th>Last Login</th>
						   </tr>
						</thead>
						<tbody>
						@foreach ($users as $user) 

						<tr>
						    <td>{{$user->id}}</td>
						    <td><a href="{{URL::route('edit-user',$user->username)}}" >{{$user->username}}</a></td>
   						    <td><a href="{{URL::route('edit-user',$user->username)}}" >{{$user->first_name}}</a></td>
						    <td><a href="{{URL::route('edit-user',$user->username)}}" >{{$user->last_name}}</a></td>
						    <td><a href="{{URL::route('edit-user',$user->username)}}" >{{$user->email}}</a></td>
						    <td><a href="{{URL::route('edit-user',$user->username)}}" >{{$user->city}}</a></td>
						    <td><a href="{{URL::route('edit-user',$user->username)}}" >{{$user->state}}</a></td>
						    <td><a href="{{URL::route('edit-user',$user->username)}}" >{{$user->sex}}</a></td>
					            <td><a href="{{URL::route('edit-user',$user->username)}}" >{{$user->birth_month."-".$user->birth_day."-".$user->birth_year}}</a></td>		
						    <td><a href="{{URL::route('edit-user',$user->username)}}" >{{$user->party}}</a></td>						  
						    <td><a href="{{URL::route('edit-user',$user->username)}}" >{{$user->role}}</a></td>
						    <td><a href="{{URL::route('edit-user',$user->username)}}" >{{$user->created_at}}</a></td>
						    <td><a href="{{URL::route('edit-user',$user->username)}}" >{{$user->last_login_at}}</a></td>						  						  
						</tr>
			    
						@endforeach
						</tbody>
				</table>
			{{ $users->links() }}
			</div>
		</section>   
	</div>
</section><!-- #pageContainer -->
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
