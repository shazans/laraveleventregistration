<meta charset="utf-8">
<meta name="description" content="">
<meta name="author" content="Jalsa">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- provide the csrf token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>Jalsa System</title>

<!-- load bootstrap from a cdn -->
<!-- Latest compiled and minified CSS 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
-->
<!-- jQuery library
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
-->

<!--mine-->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>


<!--mine-->
<!--  PAGINATION plugin-->
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css " rel="stylesheet"/>
<!--<script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"/> 

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<!--end of mine -->

<!-- Latest compiled -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> 
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>

        $(document).ready(function(){
           
           document.getElementById('addDeptId').value =  $('#cmbDept').val();
           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
           
          
        $('#dutyTable').DataTable( {
                    "destroy":true,
                    "processing": true,
                     autoWidth: false,
                    //"serverSide": true,
                    "ajax":{ 
                    "url": "{{ url('postajax') }}",
                     data: function( d ) {
                           d._token= CSRF_TOKEN;
                           d.id= $('#cmbDept').val(); 
                     
                    },
                   "dataSrc": function(data){
                        var return_data = new Array();
                        for (var i=0;i< data.data.length;i++) 
                         {
                                        return_data.push({
                                        id: data.data[i].id,
                                        Aims: data.data[i].AIMS,
                                        Status: data.data[i].dutytajneed.Status,
                                        Name: data.data[i].dutytajneed.name,
                                        Position:data.data[i].Position,
                                        Remarks: data.data[i].Remarks,
                                        Mobile: data.data[i].dutytajneed.Mobile,
                                        Branch: data.data[i].dutytajneed.tajneedbranch.branchname
                                        })

                            }
                          
                            return return_data;
                    }
                    },
                    
                    
                    /* send csrf token and the input to the controller */
                    "columns": [
                    {'data': 'id', "visible": false},
                    {'data': 'Aims', width:1 },
                    {'data': 'Status', width:1},
                    {'data': 'Name', width:3},
                    {'data': 'Position',"width":1,
                        'render': function ( data, type, row )  {
                         return '<select name="position_"><option value="'+data+'" selected>'+data+'</option><option value="Nazima">Nazima</option><option value="Naib Nazima">Naib Nazima</option><option value="Muavina">Muavina</option><option value="Special Assistant">Special Assistant</option></select>';
                     }                   
                    },
                    {'data': 'Remarks', width:2, "defaultContent": "",
                       'render': function ( data, type, row )  {
                        return '<input type="text" name="remarks_" value="'+data+'">';
                     }
                    },

                    {'data': 'Mobile', width:2, "defaultContent": "",
                        'render': function ( data, type, row ) {
                        return '<input type="text" name="mobile_" value="'+data+'">';
                    }},
                    {'data': 'Branch', width:1},
                    /* EDIT */ 
                    {'data': null, orderable: false, searchable: false,
                    'defaultContent':'<button id="updateRecord" class="btn btn-info updateRecord">Save</button><button id="deleteRecord" class="btn btn-danger deleteRecord">Delete</button>'},                    
                    ],
                   
                    buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print', 'export'
                     ],
            });
      //  });


        //aims autocomplete
        $('#aims').keyup(function(){ 
        var aims = $(this).val();
        if(aims != '')
        {
          $.ajax({
          url:"autocomplete",
          type:"GET",
          data:{aims:aims},
          success:function(data){
              
           $('#aimsList').fadeIn();  
           $('#aimsList').html(data);
         
          }
         });
        }
     });

    //aims dropdown changed
    //  $('#aims').on('change', function(){
    $(document).on('click', 'li', function(){  
        $('#aims').val($(this).text());  
        $('#aimsList').fadeOut();   
        var id = $('#aims').val();
        $('.alert-danger').hide(); 
        $.ajax({
            url: "dutyholders/getdutyholder/"+id,
            type: 'GET',                            
            success: function(response){
                document.getElementById('name').value = response['dutyHolder'].Name;
                document.getElementById('status').value =response['dutyHolder'].Status;
                document.getElementById('mobile').value =response['dutyHolder'].Mobile;
                        
                //display other duties
                $('.alert-danger').html("");
                if (response['duties'].length>0){
		          	$('.alert-danger').show(); 
                    $('.alert-danger').append('<p><b>'+ 'Other Duties' +'</b></p>');
                    //Loop through all duties 
                    for(var i=0; i<response['duties'].length;i++){
                         $('.alert-danger').append('<p>'+response['duties'][i].dutydept.deptname.toUpperCase()+'</p>');
                    }
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
			      alert("Error In Retrieving Duty Holder " +errorThrown);
			}
                    
            });
    });
        

        //dept name in dropdown changed
        $('#cmbDept').on('change', function(){
            //hide id of department in hidden field in add dutyholder form
            document.getElementById('addDeptId').value =  $('#cmbDept').val();
            //get id of table and refresh
            var table =  $('#dutyTable').DataTable();
            $('.alert-danger').hide();
            table.ajax.reload();           
        });

        
        //Download Department Dutyholder button is pressed
         $('#deptDownloadBtn').click(function () {
            var id = $('#addDeptId').val();
            var url = "{{URL::to('downloadDeptExcel')}}/"+id;
            window.location = url;   
        });


        //Delete All Dutyholders button is pressed
        $('#deleteAllBtn').click(function () {
            var id = $('#addDeptId').val();
           
            //var url = "{{URL::to('deleteAllDutyholders')}}/"+id;
            //window.location = url;  
            $.ajax({
                url: "deleteAllDutyholders/"+id,
                type: 'GET',
                data: {
                    "id": id,
                     //"_token": CSRF_TOKEN,
                    },
                    success: function(){
                        var table = $('#dutyTable').DataTable();   
                        table.ajax.reload();              
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert("Error In Deleting Duty Holders " +errorThrown);
					}				  
                    
                });
           
        });


       	//Delete button pressed
        $("#dutyTable").on("click", ".deleteRecord",function(e){
           $('.alert-danger').hide();
           var table = $('#dutyTable').DataTable();
           var tr = $(this).closest('tr');
           var row = table.row(tr);
           var delete_id = row.data().id; 
           var el = this;
           $.ajax({
                url: "dutyholders/"+delete_id,
                type: 'POST',
                data: {
                    "id": delete_id,
                    "_token": CSRF_TOKEN,
                   "_method": 'DELETE'
                    },
                    success: function(){
                        $(el).closest( "tr" ).remove();
                        alert("Duty Holder Deleted!");                                   
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert("Error In Deleting Duty Holder " +errorThrown);
					}				  
                    
                });
                
            });
            
        //Add dutyholder button is pressed
        $('#add').click(function () {
            var id = $('#addDeptId').val();
            var position = $('#position').val();
            var mobile = $('#mobile').val();
            var remarks = $('#remarks').val();
            var aims = $('#aims').val();              

        $.ajax({
            //url:'dutyholders',
            url:"dutyholders/adddutyholder",
            type:'post',
            data: {
                "_token": CSRF_TOKEN,
                  "id":id,
                  "position":position, 
                  "mobile":mobile, 
                  "remarks":remarks, 
                  "aims":aims 
             },
            success: function(){
             //refresh dutyholder table
               $('.alert-danger').hide();
               var table = $('#dutyTable').DataTable();   
               table.columns.adjust().draw();              
               table.ajax.reload(null,false);
            },
            error: function(data) {
                    $('.alert-danger').html("");
					$('.alert-danger').show();
                    //validation error in position or AIMS field
                    if( data.status === 422 ) {                 
                      $('.alert-danger').append(data.responseJSON.errors.aims);
                      $('.alert-danger').append('<p>'+data.responseJSON.errors.position+'</p>');                      
                   }
                   else{
                    $('.alert-danger').append('<p>'+'Error in adding dutyholder'+'</p>');
                   }
                   document.getElementById("aims").focus();
                   

            }
        });
            
        });


        // Save Dutyholder record
        $("#dutyTable").on("click", ".updateRecord" , function() {
            $('.alert-danger').hide();
            var edit_id = $(this).data('id');     
            var table = $('#dutyTable').DataTable();
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var editid = row.data().id; 
            var aims = row.data().Aims;
            var position = tr.find('select').val();;
            var mobile =tr.find('input[name=mobile_]').val();
            var remarks = tr.find('input[name=remarks_]').val();

        $.ajax({
            url:"dutyholders/editdutyholder",
            type:'post',
           data: {_token: CSRF_TOKEN,editid:editid,position:position, mobile:mobile, remarks:remarks, aims:aims},
            success: function(response){
                alert('Saved');

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Error In Updating Duty Holder " +errorThrown);
            }
        });
        }); 
                    
});


</script>

