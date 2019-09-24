@extends('layouts.default')
@section('content')
   

<!-- Add a New Dept Form-->
<div class="forms">
<h1>DEPARTMENTS</h1>
<form method = "POST" action = "">
  {{csrf_field()}}
 <div>
 <input type = "text" name="newdeptname" placeholder="Department" required/>
 </div>

 <div>
 <button type = "submit"> Add New Department </button>
 </div>
</form>
</div>
<br/>

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

<br/><br/>

<!-- Form to display, edit and delete all departments-->
    @foreach ($departments as $department)
    <div class="forms">
                <form method = "POST" style="display: inline;" action = "{{route('departments.update', $department->id)}}">
                {{csrf_field()}}
                {{method_field('PATCH')}}
                <input type="text" value = '{{ucwords(strtolower($department->deptname))}}' name="deptname" required/>
                <button type = "submit" name="updatebtn"> Save Department</button>
                </form>
   <!-- </div>
                <div class="forms" style="display: inline;">-->
                <form method="POST"style="display: inline;" action="{{ route('departments.destroy', $department->id)}}">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button type="submit">Delete Department</button>
                </form>
    </div>
    <br>
    @endforeach

</body>

<div>
    @foreach ($errors->all as $error)
        <li>{{$error}}</li>
    @endforeach

</div>
@stop