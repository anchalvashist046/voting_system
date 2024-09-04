<?php 
session_start();
include('connect.php');

if(isset($_POST['gvotes']) && isset($_POST['gid'])) {
    $vote = $_POST['gvotes'];
    $total_votes = $vote + 1;
    $gid = $_POST['gid'];
    $uid = $_SESSION['userdata']['id'];

    // Use prepared statements to prevent SQL injection
    $update_votes = mysqli_prepare($connect, "UPDATE user SET vote=? WHERE id=?");
    mysqli_stmt_bind_param($update_votes, 'ii', $total_votes, $gid);
    $result_votes = mysqli_stmt_execute($update_votes);

    $update_user_status = mysqli_prepare($connect, "UPDATE user SET status=1 WHERE id=?");
    mysqli_stmt_bind_param($update_user_status, 'i', $uid);
    $result_status = mysqli_stmt_execute($update_user_status);

    // Check for errors
    if($result_votes && $result_status){
        $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2");
        $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);
        $_SESSION['userdata']['status'] = 1;
        $_SESSION['groupsdata'] = $groupsdata;
        echo '<script>alert("Voting Successful!!"); window.location="./dashboard.php";</script>';
    } else {
        echo '<script>alert("Some error occurred while updating votes and user status!!"); window.location="./dashboard.php";</script>';
    }
} else {
    echo '<script>alert("Invalid request!!"); window.location="./dashboard.php";</script>';
}
?>
