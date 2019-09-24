@extends('layouts.default')
@section('content')
   

<!-- Form to add a New Branch-->

<div class="forms">
<h1>BRANCHES</h1>
<form method = "POST" style="display:inline;" action = "">
  {{csrf_field()}}



<div>
                 <label for="newregioncode">Region:</label>
                 <select name="newregioncode" type="text" required>
                 <option value="" selected></option>
                  @foreach($regions as $region)
                        <option value ="{{$region->id}}">{{ucwords(strtolower($region->regionname))}}</option>
                  @endforeach 
                  </select>
                 
</div>


<div>
  <input type = "text" name="newbranchcode" placeholder="Branch Code" required/>
</div>

<div>
 <input type = "text" name="newbranchname" placeholder="Branch Name" required/>
<div>

<div>
<button type = "submit"> Add New Branch </button>
</div>

</form>
</div>
<br/><br/>
<!--Display any errors -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Form to display, edit and delete Branches-->
  
    @foreach ($data as $d)
    <div class="forms">
                <form method = "POST" style="display: inline;" action = "{{route('branches.update', $d->id)}}">
                {{csrf_field()}}
                {{method_field('PATCH')}}
                
                <input type="text" readonly value = '{{$d->branchcode}}' name="branchcode" required/> 
                <input type="text" value = '{{$d->branchname}}' name="branchname" required/>
                <input type="text" readonly value = '{{$d->branchregion->regionname}}' name="regioncode" />
                <button type = "submit" name="updatebtn"> Save Branch</button>
                </form>

               <!-- <div class="forms">-->
                <form method="POST" style="display: inline;" action="{{ route('branches.destroy', $d->id)}}">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button type="submit">Delete Branch</button>
                </form>
    </div>
    
    @endforeach

</body>

@stop