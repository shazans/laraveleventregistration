

@extends('layouts.default')
@section('content')


   
 
    <!-- Populate a combo box with all departments.  On change display dutyholders for that department-->

        <div class="formsCmb">
        <h1>Select Department</h1>
        <form method="GET" action = "{{route('dutyholders.index')}}">
            <select class="form-control" style="width:30%;margin:auto;" name="cmbDept" id="cmbDept" type="text">
            @foreach($departments as $dept)
            <option value ="{{$dept->id}}">{{ucwords(strtolower($dept->deptname))}}</option>
            @endforeach
            </select>
         
            
        </form>          
        </div>
       
<br/>

     <!-- @if(count($errors))
            <form class="form-errors">
                <div class="alert alert-danger" style = "display:none;"> 
                <li>Hello</li>
                <li>Hello</li>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            </form>
        @endif </form>
-->

  
<div class="alert alert-danger" style="display:none;"></div>    
<p><p>
<!--buttons for downloading to excel-->
<a href="{{ URL::to('downloadExcel/{type}') }}"><button class="btn btn-success">Download All DutyHolders to Excel</button></a>
<input type="submit" id ="deptDownloadBtn" name = "deptDownloadBtn" class="btn btn-success" value="Download Department DutyHolders to Excel" >
<!--button to delete all dutyholders for department-->
<button type="button" id ="deleteAllBtn" name = "deleteAllBtn" class="btn btn-success">Delete All DutyHolders</button>

<p><p>

 <!-- Populate a table to display dutyholders for that department  <table id="dutyTable" class="table">-->
 <div class="jalsacontainer">
 <table width="100%" class="table table-striped table-bordered" id="dutyTable">     
        <thead>
				<tr>
          <th >ID</th>
        	<th >AIMS</th>
          <th >Status</th>
          <th >Name</th>
					<th >Position</th>
					<th >Remarks</th>
        	<th>Mobile</th>
					<th>Branch</th>
          <th width="70px">Action</th>
				</tr>
      </thead>
      <tbody>

      </tbody>
      </table>
</div>

<!--Add New Dutyholder Form -->

<button class="open-button" onclick="openForm()">Add DutyHolder</button>

<div class="form-popup" id="addForm">
  <form action="" class="form-container">
    <h1>Add Dutyholder</h1>
    <div id="msgalert"></div>

    <label for="AIMS">AIMS:</label>
    <input type="search" id="aims" name="aims" type="text"  placeholder="Search AIMS" class="form-control mb-1 mr-sm-1" />
           
    <div id="aimsList">
    </div>


    <label for="name"><b>Name</b></label>
    <input type="text" readonly placeholder="Enter Name" name="name" id="name" class="form-control mb-2 mr-sm-2">

    <label for="status"><b>Status</b></label>
    <input type="text" readonly name="status" id="status" placeholder="Status" class="form-control mb-1 mr-sm-1">

    <label for="Mobile">Mobile:</label>
    <input type="text" class="form-control mb-2 mr-sm-2" name="mobile" id="mobile" placeholder="Mobile">
           
    <label for="Position">Position:</label>
                <select class="form-control mb-1 mr-sm-1" name="position" id="position" >
                <option value="" selected>Position</option>
                <option value="Nazima">Nazima</option>
		            <option value="Naib Nazima">Naib Nazima</option>
		            <option value="Muavina">Muavina</option>
		            <option value="Special Assistant">Special Assistant</option>
                </select>
                
    <label for="Remarks">Remarks:</label>
    <input type="text" name="remarks" id="remarks" placeholder="Remarks" value="" class="form-control mb-1 mr-sm-1">
            
    
    <input type="hidden" name="addDeptId" id="addDeptId">
            

    <button type="button" id="add" class="btn">Add DutyHolder</button>
    <a class="btn cancel" onclick="closeForm()">Close</a>
  </form>
</div>

<script>
function openForm() {
  document.getElementById("addForm").style.display = "block";
  document.getElementById("aims").focus();
}

function closeForm() {
  document.getElementById("addForm").style.display = "none";
  $('.alert-danger').hide();
}
</script>










       @stop

      

