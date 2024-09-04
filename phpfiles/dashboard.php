<?php
    session_start();
    if(!isset($_SESSION['userdata'])){
         header("location:../login.html");
    }

    include("connect.php");
    // Get user data from session
    $userdata = $_SESSION['userdata'];

    // Query to fetch user data from the database with 'status' field included
    $result = mysqli_query($connect, "SELECT *, status FROM user WHERE mobile='{$userdata['mobile']}'");

    if ($result) {
    $user = mysqli_fetch_assoc($result);
    } else {
    // Handle database query error
    $user = null;
    }     

    // Query to fetch user data from the database
    $result = mysqli_query($connect, "SELECT * FROM user WHERE mobile='{$userdata['mobile']}'");
    if($result) {
         $user = mysqli_fetch_assoc($result);
    }
    else {
    // Handle database query error
         $user = null;
    }
    error_reporting(0);
     // Query to fetch group data
     $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2");
     $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);
     $_SESSION['groupsdata'] = $groupsdata;
     if($_SESSION['userdata']['status']==0)
     {
        $status='<b>NOT VOTED<b>';
     }
     else{
        $status='<b > VOTED<b>';
     }
    

?>
<!DOCTYPE html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../cssfiles/dashboard.css">
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="../images-assets/logo.jpg" alt="Web-Elect Logo" class="logo">
        </div>
        <h1 class="heading">Web-Elect</h1>
        <nav class="navbar">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="../login.html" class="nav-link">Back</a>
                </li>
                <li class="nav-item">
                    <a href="./logout.php" class="nav-link">Logout</a>
                </li>
            </ul>
        </nav>
    </div>
    <hr>
    <h2 style="color:#1A4D2E" >Your Profile</h2><hr>
    <div id="profile">
    

        <b>Name :</b> <?php echo $user['name'] ?><br>
        <b>Mobile :</b> <?php echo $user['mobile']  ?><br>
        <b>Address :</b> <?php echo $user['address']  ?><br>
        <b>Status :</b> <?php echo $status ?><br>
    </div><hr>
        
    
    <h2 style="color:#1A4D2E" style="margin-left:300px" >Groups</h2>
    <hr><br>
    <?php
    if($_SESSION['groupsdata']) {
        for($i=0;$i<count($groupsdata);$i++){
            ?>
           <div id="group">
            <b>Group Name:</b> <?php echo $groupsdata[$i]['name']?><br><br>
            <b>votes: </b><?php echo $groupsdata[$i]['vote']?></b><br><br>
            <form action="./vote.php" method="POST">
                <input type="hidden" name="gvotes" value="<?php echo $groupsdata[$i]['vote']?>">
                <input type="hidden" name="gid" value="<?php echo $groupsdata[$i]['id']?>">
                <?php
                   if($_SESSION['userdata']['status']==0){
                ?>
                 <input type="submit" name="votebtn" value="vote" id="votebtn"><br>
                 <?php
                   }
                   else{
                    ?>
                    <button disabled type="button" name="votebtn" value="vote" id="voted">Voted</button>
                   <?php
                }
                ?>
                <br>
            </form>
           </div>
           <hr>
           <?php
           
        }
             
       }
    ?>
    <footer class="footer">
        <p>&copy; 2024 Web-Elect. All Rights Reserved.</p>
    </footer>

</div>
</body>
</html>