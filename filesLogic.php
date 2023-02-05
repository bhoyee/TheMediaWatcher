<?php
// connect to the database
$conn = mysqli_connect('localhost', 'xxxxxxzxx', 'xxxxxxx', 'xxxxxxxxxxx');

// Downloads files
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM files WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'admin/uploads/' . $file['name'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('admin/uploads/' . $file['name']));
        readfile('admin/uploads/' . $file['name']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE files SET downloads=$newCount WHERE id=$id";
        mysqli_query($conn, $updateQuery);
        exit;
    }

}

// delete file 
    // extract($_REQUEST);

    // $sql=mysqli_query($conn,"select * from files where id='$del'");
    // $row=mysqli_fetch_array($sql);

    // unlink("files/$row[name]");

    // mysqli_query($conn,"delete from files where id='$del'");

    // header("Location:sindex.php");

    extract($_REQUEST);


// $sql=mysqli_query($conn,"select * from files where id='$del'");
// $row=mysqli_fetch_array($sql);

// unlink("uploads/$row[name]");

// mysqli_query($conn,"delete from files where id='$del'");

// header("Location:sindex.php");


if(isset($_POST['deletedata']))
{
    $del = $_POST['delete_id'];

  
$sql=mysqli_query($conn,"select * from files where id='$del'");
$row=mysqli_fetch_array($sql);

unlink("uploads/$row[name]");

mysqli_query($conn,"delete from files where id='$del'");

header("Location:sindex");

    // $querydel = "DELETE FROM users WHERE id='$id'";
    // $query_del = query($querydel);
    // confirm($query_del);

    // if($query_del)
    // {
    //     echo '<script> alert("User Data Deleted"); </script>';
    //     echo "<meta http-equiv='refresh' content='0'>";// auto refresh the page
    //     // header("Location:index.php");
    // }
    // else
    // {
    //     echo '<script> alert("Data Not Deleted"); </script>';
    // }
}