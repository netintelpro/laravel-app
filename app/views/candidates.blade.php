@include('header')
<section id="pageContainer" class="section">
	<div class="container">
		<section id="results">
			<div class="table-responsive">
				<table class="table">
					<thead>
						  <tr>
						    <th>candidate_id</th>
						    <th>profilePic</th>
						    <th>candidate_fname</th>
						    <th>candidate_state</th>
						    <th>candidate_city</th>
						    <th>candidate_partyname</th>
						    <th>candidate_desig</th>
						    <th>candidate_type</th>
						    <th>candidate_district</th>
						  </tr>
						</thead>
						<tbody>
						@foreach (Candidate::all() as $candidate) 

						<tr>
						    <td>{{$candidate->id}}</td>
						    <td>{{substr($candidate->profilePic,0,6)}}</td>
						    <td>{{$candidate->candidate_fname}}</td>
						    <td>{{$candidate->state->title}}</td>
						    <td>{{$candidate->candidate_city}}</td>
						    <td>{{$candidate->candidate_partyname}}</td>
						    <td>{{$candidate->candidate_desig}}</td>
						    <td>{{$candidate->candidate_type}}</td>
						    <td>{{$candidate->candidate_district}}</td>
						  </tr>
			  

			  
			   
						@endforeach
						</tbody>
				</table>
			</div>
		</section>   
	</div>
</section><!-- #pageContainer -->
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
