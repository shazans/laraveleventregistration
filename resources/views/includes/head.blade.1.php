<meta charset="utf-8">
<meta name="description" content="">
<meta name="author" content="Jalsa">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- provide the csrf token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>Jalsa System</title>

<!-- load bootstrap from a cdn -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> 





<!--<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" >-->
<script>

        $(document).ready(function(){




            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            
          //  $("#cmbDept").change(function(){
            $("#cmbDept").on('change', function(e) {

                //hide id of department in hidden field in add dutyholder form
                var selDept = $('#cmbDept').val();
                document.getElementById('addDeptId').value =  $('#cmbDept').val();
                var tr_str = '';
                $("#dutyTable tr").not(':first').remove();
                
                $.ajax({
                    /* the route pointing to the post function */
                    url:  'postajax', 
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, id: $('#cmbDept').val()},
                    /* 'data' is the response of the AjaxController */
                    success: function (data) {
                    
                    var dutyholder = JSON.parse(data.msg);
                    filltable(dutyholder);
                    //e.preventDefault(); //dont trigger a refresh of whole page
                        
                   /* loop through response and display dutyholders in table 
                   if (dutyholder.length>0){

                    //e.preventDefault(); //dont trigger a refresh of whole page
            
                       
                        for (var i=0;i< dutyholder.length;i++) {
                         tr_str = "<tr>" +
                        "<td><input type='text' value='" + dutyholder[i].id + "' id='id_' disabled></td>"+
                        "<td align='center'><input type='text' value='" + dutyholder[i].AIMS + "' name= 'aims_' id='aims_' disabled></td>" + 
                        "<td align='center'><input type='text' value='" + dutyholder[i].dutytajneed.name + "' name = 'name_' id='name_"+dutyholder[i].id+"' disabled></td>" +
                        "<td align='center'><input type='text' value='" + dutyholder[i].dutytajneed.tajneedbranch.branchname + "' id='branch_"+dutyholder[i].id+"' disabled></td>" +
                        "<td><select name='position_' id='position_'><option selected value='" + dutyholder[i].Position + "' >"  + dutyholder[i].Position + "</option><option value='Nazima'>Nazima</option><option value='Naib Nazima'>Naib Nazima</option><option value='Muavina'>Muavina</option><option value='Special Assistant'>Special Assistant</option></select></td>" +
                        "<td align='center'><input type='text' value='" + dutyholder[i].dutytajneed.Mobile + "' id='mobile_' name='mobile_'></td>" +
                        "<td align='center'><input type='text' value='" + dutyholder[i].Remarks + "' id='remarks_' name='remarks_'></td>" +
                        "<td align='center'><input type='button' name = 'Update' data-id='" + dutyholder[i].id + "' data-position='" + $('#position_').val() +"' data-aims ='" + dutyholder[i].AIMS +"' data-mobile='" + dutyholder[i].dutytajneed.Mobile + "' data-remarks='" + dutyholder[i].Remarks + "' class='updateRecord btn btn-outline-info' >" +
                         "<td align='center'><input type='button' value='Delete' class='deleteRecord btn btn-outline-danger' data-id='"+dutyholder[i].id+"' >" +
                        "</tr>;"                     
                        $('#dutyTable tr').first().after(tr_str);  
                             
                        }
                        
                      
                    } 
                    else{
                        var tr_str = '';
                    $("#dutyTable tr").not(':first').not(':last').remove();
                       tr_str = "<tr class='norecord'>" +
                       "<td align='center' colspan='4'>No Duty Holders found.</td>" +
                       "</tr>";                      
                       $('#dutyTable tr').first().after('No');   
                    }
                    */
                    },
                    /*show error in returning duty holders*/
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert("Error In Loading Duty Holders" +" "+errorThrown);
					}		
                   
                }); 
            });
        

            $.ajax({
                url: 'departments',
                type: 'get',
                success: function(data){
                 //trigger a refresh of the  dutyholders table
                $('#cmbDept').trigger('change');  
                               },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Page Error: ' + xhr.responseText;
                    $('#tbDetails').html(errorMsg);
                  }
            });


            
            // Delete dutyholder record
            $("#dutyTable").on("click", ".deleteRecord",function(){
            var delete_id = $(this).data('id');
            var el = this;
            $.ajax({
                url: "dutyholders/"+delete_id,
                type: 'DELETE',
                data: {
                    "id": delete_id,
                    "_token": CSRF_TOKEN,
                    },
                    success: function(response){
                    $(el).closest( "tr" ).remove();
                     },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert("Error In Deleting Duty Holder " +errorThrown);
					}				  

                });
            });
            

            $('#addForm').on('submit', function(e) {
               e.preventDefault(); 
               deptId= $('#addDeptId').val(); 
               //window.location.reload();
               document.getElementById('cmbDept').value= deptId;
            //  alert(document.getElementById('cmbDept').value);
            //   $('#cmbDept').trigger('change');
            });  
            
            //add dutyholder button is pressed
            //$('#add').click(function () {
                
           $('#add').on('click', function(e) {
           
            var id = $('#addDeptId').val();
            var position = $('#position').val();
            var mobile = $('#mobile').val();
            var remarks = $('#remarks').val();
            var aims = $('#aims').val();
            $.ajax({
            url:'dutyholders',
            type:'post',
            data: {_token: CSRF_TOKEN,id:id,position:position, mobile:mobile, remarks:remarks, aims:aims },
            success: function(response){
                   
            /*    if (response.status = 'error'){
                  
                 $.each( response.msg, function( key, value ) {
                  $('.alert-danger').show();
                  $('.alert-danger').append('<p>'+value+'</p>');
                 
                  });
               }
                
               else{
                */
                //display dutyholders for department
                var dutyholder = JSON.parse(response.msg);
               
                
                tr_str='';
                i=0;
                tr_str = "<tr>" +
                "<td align='center'><input type='text' value='" + dutyholder[i].AIMS + "' id='aims_' disabled></td>" + 
                "<td align='center'><input type='text' value='" + dutyholder[i].dutytajneed.name + "' id='name_"+dutyholder[i].id+"' disabled></td>" +
                "<td align='center'><input type='text' value='" + dutyholder[i].dutytajneed.tajneedbranch.branchname + "' id='branch_"+dutyholder[i].id+"' disabled></td>" +
                "<td><select name='position_' id='position_'><option selected value='" + dutyholder[i].Position + "' >"  + dutyholder[i].Position + "</option><option value='Nazima'>Nazima</option><option value='Naib Nazima'>Naib Nazima</option><option value='Muavina'>Muavina</option><option value='Special Assistant'>Special Assistant</option></select></td>" +
                "<td align='center'><input type='text' value='" + dutyholder[i].dutytajneed.Mobile + "' id='mobile_'></td>" +
                "<td align='center'><input type='text' value='" + dutyholder[i].Remarks + "' id='remarks_'></td>" +
                "<td align='center'><input type='button' name = 'Update' value = 'Update' data-id='" + dutyholder[i].id + "' data-position='" + $('#position_').val() +"' data-aims ='" + dutyholder[i].AIMS +"' data-mobile='" + dutyholder[i].dutytajneed.Mobile + "' data-remarks='" + dutyholder[i].Remarks + "' class='updateRecord btn btn-info btn-primary btn-sm' ><span class='glyphicon glyphicon-pencil'></span>" +
                // "<td align='center'><input type='button' value='Delete' class='deleteRecord btn btn-outline-danger' data-id='"+dutyholder[i].id+"' ><span class='glyphicon glyphicon-trash'></span>" +
                "<td align='center'><input type='button' value='Delete' class='deleteRecord btn btn-primary btn-sm' data-id='"+dutyholder[i].id+"' ><span class='glyphicon glyphicon-trash'></span>" +
                "<td><input type='hidden' value='" + dutyholder[i].id + "' id='id_' disabled></td>"+
                "</tr>;"                     
               // $('#dutyTable tr').append(tr_str);  
               $('#dutyTable tr').first().after(tr_str);
             //  }
                
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
					//alert("Error In Adding Duty Holder " +errorThrown);
                    $('.alert-danger').show();
                  	$('.alert-danger').append('<p>'+errorThrown+'</p>');
                   
                }
               
            });

            });


            // Update record
            $("#dutyTable").on("click", ".updateRecord" , function() {
            
            //get department id
            var deptid = $('#addDeptId').val();
			//get row data and id of dutyholder
            var edit_id = $(this).data('id');       
            var currentRow = $(this).closest("tr");
            var aims = currentRow.find('input[name=aims_]').val();
            var position = currentRow.find('select').val();
            var mobile =currentRow.find('input[name=mobile_]').val();
            var remarks = currentRow.find('input[name=remarks_]').val();
            
            $.ajax({
            url:'editduty',
            type:'post',
            data: {_token: CSRF_TOKEN,deptid:deptid, editid:edit_id,position:position, mobile:mobile, remarks:remarks, aims:aims},
            success: function(response){
                var dutyholder = JSON.parse(response.msg);
                //if returns success TEST need to be put
                currentRow.find('select').val()= position ;
                currentRow.find('input[name=mobile_]').val() = mobile;
                currentRow.find('input[name=remarks_]').val() = remarks;
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert("Error In Updating Duty Holder " +errorThrown);
            }
            });
            });           
        });

//function to display dutyholder list
function filltable(dutyholder)
{
        //$("#dutyTable tr").not(':first').remove();
        tr_str='';
       // i = 0;                
        //loop through response and display dutyholders in table 
        for (var i=0;i< dutyholder.length;i++) {
        tr_str = "<tr>" +
        "<td align='center'><input type='text' value='" + dutyholder[i].AIMS + "' id='aims_' disabled></td>" + 
        "<td align='center'><input type='text' value='" + dutyholder[i].dutytajneed.name + "' id='name_"+dutyholder[i].id+"' disabled></td>" +
        "<td align='center'><input type='text' value='" + dutyholder[i].dutytajneed.tajneedbranch.branchname + "' id='branch_"+dutyholder[i].id+"' disabled></td>" +
        "<td><select name='position_' id='position_'><option selected value='" + dutyholder[i].Position + "' >"  + dutyholder[i].Position + "</option><option value='Nazima'>Nazima</option><option value='Naib Nazima'>Naib Nazima</option><option value='Muavina'>Muavina</option><option value='Special Assistant'>Special Assistant</option></select></td>" +
        "<td align='center'><input type='text' name='mobile_' value='" + dutyholder[i].dutytajneed.Mobile + "' id='mobile_'></td>" +
        "<td align='center'><input type='text' name='remarks_' value='" + dutyholder[i].Remarks + "' id='remarks_'></td>" +
        "<td align='center'><input type='button' name = 'Update' value = 'Update' data-id='" + dutyholder[i].id + "' data-position='" + $('#position_').val() +"' data-aims ='" + dutyholder[i].AIMS +"' data-mobile='" + dutyholder[i].dutytajneed.Mobile + "' data-remarks='" + dutyholder[i].Remarks + "' class='updateRecord btn btn-info btn-primary btn-sm' ><span class='glyphicon glyphicon-pencil'></span>" +
        // "<td align='center'><input type='button' value='Delete' class='deleteRecord btn btn-outline-danger' data-id='"+dutyholder[i].id+"' ><span class='glyphicon glyphicon-trash'></span>" +
        "<td align='center'><input type='button' value='Delete' class='deleteRecord btn btn-primary btn-sm' data-id='"+dutyholder[i].id+"' ><span class='glyphicon glyphicon-trash'></span>" +
        "<td><input type='hidden' value='" + dutyholder[i].id + "' id='id_' disabled></td>"+
        "</tr>;"                     
        $('#dutyTable tr').first().after(tr_str);     
        }
                    
}


    </script>

