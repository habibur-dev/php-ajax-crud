<?php

$search = $_POST['search'];

$conn = mysqli_connect("localhost", "root", "", "ajaxcrud") or die("Connection Failed!");
$sql = "SELECT * FROM students WHERE student_name LIKE '%{$search}%' OR student_grade LIKE '%{$search}%'";

$result = mysqli_query($conn, $sql) or die("Query Failed!");

if(mysqli_num_rows($result) > 0){
    $output = '<table class="table mt-4">
                <thead class="table-dark">
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Grade</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>';
                while($row = mysqli_fetch_assoc($result)){
                    $output .= "<tr>
                                    <td>{$row["id"]}</td>
                                    <td>{$row["student_name"]}</td>
                                    <td  style='width: 20%;'>{$row["student_grade"]}</td>
                                    <td style='width: 18%;'>
                                        <button type='button' class='btn btn-danger delete_std' data-id='{$row["id"]}'>Delete</button>
                                        <button type='button' class='btn btn-primary edit_std' data-edit-id='{$row["id"]}' data-bs-toggle='modal' data-bs-target='#recordEditForm'>Edit</button>
                                    </td>
                                </tr>";
                }
    $output .= "</tbody>
                </table>";
    mysqli_close($conn);
    echo $output;
}else{
    $output = '
        <table class="table mt-4">
            <thead class="table-dark">
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Grade</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="4" class="text-center p-3"><h5>No Record Found!!!</h5></tr>
            </tbody>
            </table>
    ';

    echo $output;
}