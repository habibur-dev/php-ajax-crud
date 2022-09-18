<?php

$editID = $_POST['editID'];
$editName = $_POST['editName'];
$editGrade = $_POST['editGrade'];

$conn = mysqli_connect("localhost", "root", "", "ajaxcrud") or die("Connection Failed!");
$sql = "UPDATE students SET student_name = '{$editName}', student_grade = '{$editGrade}' WHERE id = '{$editID}'";

$result = mysqli_query($conn, $sql) or die("Query Failed!");

if(mysqli_query($conn, $sql)){
    echo 1;
}else{
    echo 0;
}