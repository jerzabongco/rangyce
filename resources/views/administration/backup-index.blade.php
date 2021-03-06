{{-- <link href="{{ asset('css/admin/bootstrap.min.css') }}" rel="stylesheet"> --}}
<link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/never_touch_mc/modal.min.css') }}" rel="stylesheet">
{{-- Datatable --}}
<link rel="stylesheet" type="text/css" href="{{ asset('css/never_touch_mc/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/never_touch_mc/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/never_touch_mc/responsive.bootstrap4.min.css') }}">

<div class="modal fade" id="add-modal"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      	<div class="modal-header">
        	<h3 class="modal-title" id="exampleModalLongTitle">Add New Police Station</h3>
      	</div>
		<div class="modal-body">
			<form id="adding-form" method="get" enctype="multipart/form-data">	
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						    <input type="text" class="form-control" id="name_of_station" aria-describedby="emailHelp" placeholder="Station Name" required>		    	
						 </div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" class="form-control" id="state" aria-describedby="emailHelp" placeholder="State" required>
						</div>	
					</div>        	
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" class="form-control" id="city" aria-describedby="emailHelp" placeholder="City" required>	
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" class="form-control" id="street" aria-describedby="emailHelp" placeholder="Street" required>	
						</div>			
					</div> 
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" class="form-control" id="zip" aria-describedby="emailHelp" placeholder="Zip Code" required>	
						</div>		
					</div>
					<div class="col-md-6">
						<div class="form-group">
						    <input type="file" class="form-control-file" id="file_path"  accept="image/*">
						</div>
					</div>        	
				</div>			
			</form>			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" id="save-new-PS">Add Station</button>
		</div>
    </div>
  </div>
</div>
@include('layouts.app')	

<!-- This section is for the table of the police station -->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6">
					<h2>Police Stations</h2>				
				</div>
				<div class="col-md-6">
					<a class="btn btn-primary" href="#" id="add-station-btn">Add Station</a>
				</div>
			</div>
			<table class="table table-striped table-bordered dt-responsive nowrap" id="list-police-table" style="width: 100%; margin-bottom: 40px;">
				<thead>
					<tr>
						<th>Name of Station</th>
						<th>State</th>
						<th>City</th>
						<th>Address</th>
						<th>Zip Code</th>
						<th>Date Added</th>
						<th>Options</th>							
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>
@include('layouts.bottomAdmin')
<script src="{{ asset('js/jquery-1.11.0.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('js/moment-with-locales.js') }}"></script>
<script src="{{ asset('js/modal.min.js') }}"></script>		
<script src="{{ asset('js/modalmanager.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2@8.0.7.js') }}"></script>
<script type="text/javascript">
	$(document).ready( function () {
	    console.log( "ready!" );
	    $('#add-station-btn').click(function(e){
	    	e.preventDefault();
	    	$('#add-modal').modal('show');
	    });

	    $('#list-police-table').DataTable({
	    		responsive: true,
	           "processing": true,
	           "ajax": "{{ route('get_list_Station') }}",
	           columns: [
                    { 
                        data: 'name_of_station'
                    },                
                    {
                        data: 'state',
                    },
                    { 
                        data: 'city'
                    },                
                    {
                        data: 'street',
                    },
                    { 
                        data: 'zip'
                    },                
                    {
                        data: 'created_at',
                        render: function ( data, type, row ) 
                        {
                        	return moment(data).format('llll');
                        }
                    },
                    {
                    	data: null,
                    	render: function()
                    	{
                    		return '<button class="btn btn-primary">Edit</button>';
                    	}
                    }
                ],
	       } );

        // Add new police station
        // var formData = new FormData($('#adding-form')[0]);
    	$('#save-new-PS').click(function(){
    		var $this = $(this);    		
    		$.ajax({
    			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    			url: '{{route('add_new_station')}}',
    			type: 'POST',
    			// data: formData,
    			// contentType: false,
    			// processData: false,
    			data: {
    				name: $('#name_of_station').val(),
    				state: $('#state').val(),
    				city: $('#city').val(),
    				street: $('#street').val(),
    				zip: $('#zip').val(),
    				file_path: $('#file_path').val()
    			},
    			success:function(data){ 
    				console.log(data, data.success);
    			    if(data.success)
    			    {
    			    	Swal.fire(
    			    	      '',
    			    	      'Successfuly Added',
    			    	      'success'
    			    	    )      
    			    	$('#add-modal').modal('hide'); 
    			    }                  
    			},
    		});
    	});
	});				
</script>