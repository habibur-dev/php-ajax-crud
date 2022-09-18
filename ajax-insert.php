<?php

$student_name = $_POST['studentName'];
$student_grade = $_POST['studentGrade'];

$conn = mysqli_connect("localhost", "root", "", "ajaxcrud") or die("Connection failed!");

$sql = "INSERT INTO students(student_name, student_grade) VALUES ('{$student_name}', '{$student_grade}')";

if(mysqli_query($conn, $sql)){
    echo 1;
}else{
    echo 0;
}