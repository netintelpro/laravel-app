@include('header')
<section id="pageContainer" class="section">
	<div class="container">
		<section id="results">
		<h1>Admin</h1>
		<ul>
			<li><a href="{{URL::route('admin-users')}}">Users</a></li>
			<li><a href="{{URL::route('admin-comments')}}">Comments</a></li>
			<li><a href="{{URL::route('admin-issues')}}">Issues</a></li>
			<li><a href="{{URL::route('admin-politicians')}}">Politicians</a></li>
			<li><a href="{{URL::route('admin-polls')}}">Polls</a></li>
			<li><a href="{{URL::route('admin-searches')}}">Searches</a></li>
			<li><a href="">Manual(Pending)</a></li>


			<li><a href="">Pages(Pending)</a></li>
			<li><a href="">Menues(Pending)</a></li>
			<li><a href="">Posts(Pending)</a></li>		
		</ul>
		</section>   
	</div>
</section><!-- #pageContainer -->
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
