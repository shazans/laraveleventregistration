@extends('layouts.default')
@section('content')
   

<!-- Form to add a New Region-->
<div class="forms">
<h1>REGIONS</h1>
<form method = "POST" style="display:inline;" action ="">
  {{csrf_field()}}
 <div>
 <input type = "text" name="newregioncode" placeholder="Region Code" required/>
 </div>

 <div>
 <input type = "text" name="newregioname" placeholder="Region Name" required/>
 </div>
 
 <div>
 <button type = "submit"> Add New Region </button>
 </div>
</form>
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

<div>

<!-- Form to display, edit and delete Regions-->
    @foreach ($regions as $region)

    <div class="forms">
                <form method = "POST" style="display: inline;" action = "{{route('regions.update', $region->id)}}">
                {{csrf_field()}}
                {{method_field('PATCH')}}
                
                <input type="text" readonly value = '{{$region->regioncode}}' name="regioncode" required/> 
                <input type="text" value = '{{$region->regionname}}' name="regionname" required/>
                <button type = "submit" name="updatebtn"> Save Region</button>
                </form>
<!--    </div>
                <div class="forms">-->
                <form method="POST" style="display: inline;" action="{{ route('regions.destroy', $region->id)}}">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button type="submit">Delete Region</button>
                </form>
    </div>

    @endforeach

</body>

<div>
    @foreach ($errors->all as $error)
        <li>{{$error}}</li>
    @endforeach

</div>
@stop