
@extends('layouts.default')
@section('content')



<div class="form-popup" id="myForm">
<div class="content-section">
<div class="body-section">
	
	
	<form method="POST" action = "">   
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	

			
		</select>
		<div class="form-input">
		ID: <input type = "text" id= "fid" name="fid">
		</div>

		<div class="form-input">
		BRANCH: <input type = "text" id= "newBranch" name="newBranch" readonly >
		</div>

		<div class="combo">
		POSITION: <select name="newPosition" id="newPosition">
		<option value="Nazima">Nazima</option>
		<option value="Naib Nazima">Naib Nazima</option>
		<option value="Muavina">Muavina</option>
		<option value="Special Assistant">Special Assistant</option>
		</select>
		</div>

		<div class="form-input">
		MOBILE: <input type = "text" id="newMobile" name="newMobile">
		</div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        

		
	</form>
    </div>
    </div>
    </div>


@stop






