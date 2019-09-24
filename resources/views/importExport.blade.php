@extends('layouts.default')
@section('content')


<!--display success and error messages in view -->
@if(count($errors) > 0)
    <div class="alert alert-danger">
     Upload Validation Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif

@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

@if (session('success'))
  <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <strong> {{ session('success') }} </strong>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-danger" style="margin: 15px;">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <strong> {{ session('error') }} </strong>
  </div>
@endif

   <!--buttons to upload files document.body.style.cursor = 'default'; // normal cursor-->
	<form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
	<input style="width:25%;" type="file" name="import_file" />
	<button class="btn btn-primary">Import Tajneed File</button>
	</form>

   <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ URL::to('importBranchesExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
	<input style="width:25%;" type="file" name="import_branchfile" />
	<button class="btn btn-primary">Import Branch File</button>
   </form>
   
   <form id="impform" style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ URL::to('importdutyHoldersExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
	<input style="width:25%;" type="file" name="import_dutyholdersfile" id= "import_dutyholdersfile" />
	<button class="btn btn-primary">Import DutyHolders</button>
	
</form>
<br>

<!-- Export double duties to excel-->                    
<input type="submit" id ="ddDownloadBtn" name = "ddDownloadBtn" class="btn btn-success" value="Download Double Duties" >
<button id ="ddClearBtn" name = "ddClearBtn" class="btn btn-primary">Clear Double Duties Window</button>
	

<!-- Populate a table to display dutyholders for that department-->


@if (session('duties'))


<div id ="doubleduties">
<h1>Double Duties in {{ucwords(strtoupper(Session::get('duties')['filetitle']))}}</h1>
<br>

 <table width="80%" class="table table-striped table-bordered" id="ddTable">     
   <thead>
		<tr>
        	<th >AIMS</th>
         <th >Name</th>		
        	<th>Position</th>
			<th>Department</th>
		</tr>
   </thead>

   <tbody>
      @foreach(Session::get('duties')['listduty'] as $duty)
      <tr>
      <td>{{$duty["aims"]}} </td>
      <td>{{$duty["name"]}} </td>
      <td>{{$duty["position"]}}</td>
      <td> {{$duty["dept"]}}</td>
      
      </tr>
      @endforeach
   </tbody>
   </table>
   @endif
</div>



<script>
//Clear double duties window in upload page
$('#ddClearBtn').click(function () {
    document.getElementById('doubleduties').innerHTML = "";      
});

 //Download DoubleDutyholder button is pressed
 $('#ddDownloadBtn').click(function () {
   
     var url = "{{URL::to('downloadDoubleDutiesExcel')}}";
     window.location = url;
    
});

</script>
@stop