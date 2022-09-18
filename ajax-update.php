<?php

$editID = $_POST['editID'];

$conn = mysqli_connect("localhost", "root", "", "ajaxcrud") or die("Connection Failed!");
$sql = "SELECT * FROM students WHERE id = {$editID}";

$result = mysqli_query($conn, $sql) or die("Query Failed!");

$output = "";
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $output .= "<form>
                    <div class='mb-3'>
                        <label for='student-name' class='col-form-label'>Student Name:</label>
                        <input type='text' class='form-control' id='student-name' value='{$row["student_name"]}'>
                        <input type='hidden' class='form-control' id='edit-id' value='{$row["id"]}'>
                    </div>
                    <div class='mb-3'>
                        <label for='student-grade' class='col-form-label'>Grade:</label>
                        <input type='text' class='form-control' id='student-grade' value='{$row["student_grade"]}'>
                    </div>
                </form>
        ";
    }
    mysqli_close($conn);
    echo $output;
}else{
    echo "<h3>No Record Found!</h3>";
}