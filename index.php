<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP AJAX-CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  </head>
  <body>
    
    <div class="container">
        <h2 class="text-white text-center bg-black p-3">PHP AJAX-CRUD</h2>
        <div class="alert alert-success text-center" role="alert" id="alert-success" style="display: none;">
    
        </div>
        <div class="alert alert-danger text-center" role="alert" id="alert-danger" style="display: none;">

        </div>
        <div class="">
            <div class="d-flex justify-content-center mt-5">
                <form class="row data-add-form" id="data-add-form">
                    <div class="col-auto">
                        <input type="text" class="form-control" id="studentName" placeholder="Name">
                    </div>
                    <div class="col-auto">
                        
                        <input type="text" class="form-control" id="studentGrade" placeholder="Grade">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3" id="add_data">Add Data</button>
                    </div>
                </form>
            </div>
            <div class="d-flex justify-content-center mx-auto" style="max-width: 555px;">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Search</span>
                    <input type="text" class="form-control" placeholder="Start typing..." aria-describedby="basic-addon1" id="search">
                </div>
            </div>
            <!-- <button class="btn btn-primary mt-4" id="load-data">Load Data</button> -->
        </div>
        
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="table-data">
                    
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <div>
        <div class="modal fade" id="recordEditForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="edit-data">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close_modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update_record">Update Record</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){


            //load data
            function loadData(){
                $.ajax({
                    url: "ajax-load.php",
                    type: "POST",
                    success: function(data){
                        $(".table-data").html(data);
                    }
                });
            }

            loadData();

            //add data in db
            $("#add_data").on("click", function(e){
                e.preventDefault();

                let studentName = $("#studentName").val();
                let studentGrade = $("#studentGrade").val();

                if(studentName == "" || studentGrade == ""){
                    $("#alert-danger").html("All fields are required").slideDown();
                    $("#alert-success").slideUp();
                }else{
                    $.ajax({
                    url: "ajax-insert.php",
                    type: "POST",
                    data: {studentName: studentName, studentGrade: studentGrade},
                    success: function(data){
                        if(data == 1){
                            loadData();
                            $("#data-add-form").trigger("reset");
                            $("#alert-success").html("Student Added Successfully!").slideDown();
                            $("#alert-danger").slideUp();
                        }else{
                            $("#alert-danger").html("All fields are required").slideDown();
                            $("#alert-success").slideUp();
                        }
                    }
                });
                } 
            });

            //record deleting
            $(document).on("click", ".delete_std", function(){
                if(confirm("Do you want to delete this record?")){
                    let studentID = $(this).data("id");
                    let deletedRow = this;
                    $.ajax({
                        url: "ajax-delete.php",
                        type: "POST",
                        data: {id: studentID},
                        success: function(data){
                            if(data == 1){
                                $(deletedRow).closest("tr").fadeOut();
                            }else{
                                $("#alert-danger").html("Can't delete record!").slideDown();
                                $("#alert-success").slideUp();
                            }
                        }
                    });
                }
                
            });

            // edit record show data
            $(document).on("click", ".edit_std", function(){
                let editID = $(this).data("edit-id");

                $.ajax({
                    url: "ajax-update.php",
                    type: "POST",
                    data: {editID: editID},
                    success: function(data){
                        $("#edit-data").html(data);
                    }
                });

            });

            // edit record update data
            $(document).on("click", "#update_record", function(){
                let editID = $("#edit-id").val();
                let editName = $("#student-name").val();
                let editGrade = $("#student-grade").val();

                $.ajax({
                    url: "ajax-update-from.php",
                    type: "POST",
                    data: {editID: editID, editName:editName, editGrade:editGrade},
                    success: function(data){
                        if(data == 1){
                            $(".btn-close").click();
                            loadData();
                        }
                    }
                });
            });

            //live search
            $("#search").on("keyup", function(){
                let search_key = $(this).val();

                $.ajax({
                    url: "ajax-live-search.php",
                    type: "POST",
                    data: {search: search_key},
                    success: function(data){
                        $(".table-data").html(data);
                    }
                });
            });

            $('body').bind('keypress', function(e) {
                var code = e.key || e.which || e.code || e.keyCode;
                if(code == "/") { 
                    e.preventDefault();
                    $("#search").focus();
                    return;
                }
            });

            $('body').bind('keypress', function(e) {
                var code = e.key || e.which || e.code || e.keyCode;
                if(code == "insert") { 
                    e.preventDefault();
                    $("#studentName").focus();
                    console.log(code);
                    return;
                }
            });
        });
        
        
    </script>
  </body>
</html>