<?php
@include 'connect.php';
$crewID = $_GET['edit'];

if(isset($_POST['update_crew'])){
    $crewName = $_POST['crewName'];
    $role = $_POST['role'];
    $nationality = $_POST['nationality'];
    $joinDate = $_POST['joinDate'];
    $email = $_POST['contactInfo'];
    $crewImg = $_FILES['crewImg']['name'];
    $shipID = $_POST['shipID'];
    $crewImg_tmp_name = $_FILES['crewImg']['tmp_name'];
    $crewImg_folder = 'images/' . $crewImg;

    if (empty($crewName) || empty($role) || empty($nationality) || empty($joinDate) || empty($email) || empty($crewImg)) {
        $message[] = 'Please fill out all fields.';
    } else {
        $check_ship = mysqli_query($conn, "SELECT * FROM ships WHERE shipID = '$shipID'");
        
        if (mysqli_num_rows($check_ship) > 0) {
            $update = "UPDATE crew SET crewName='$crewName', role='$role', nationality='$nationality', joinDate='$joinDate', contactInfo='$email', crewImg='$crewImg', shipID='$shipID' WHERE crewID = $crewID";
            
            $upload = mysqli_query($conn, $update);

            if ($upload) {
                move_uploaded_file($crewImg_tmp_name, $crewImg_folder);
                $message[] = 'Member updated successfully.';
            } else {
                $message[] = 'Could not update this member.';
            }
        } else {
            $message[] = 'Invalid ship ID.';
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin update</title>
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/all.min.css">
    <!-- css link  -->
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="admin-crew centered">
<div class="container ">
   <?php
       $select = mysqli_query($conn, "SELECT * FROM crew WHERE crewID = $crewID");
       while($row = mysqli_fetch_assoc($select)){
        ?>
            <div class="title">update Member Crew</div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <?php
               if(isset($message)){
               foreach($message as $message){
               echo '<span class="error-msg">' .$message. '</span>';
              }
             }
            ?>
            <div class="user-details">
                        <div class="input-box">
                            <span class="details">Crew Name</span>
                            <input type="text" placeholder="Enter the name of a crew member" id="crewName" value="<?php echo $row['crewName'];?>" name="crewName" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Role</span>
                            <input type="text" placeholder="Enter Role" id="role" value="<?php echo $row['role'];?>" name="role" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Nationality</span>
                            <input type="text" placeholder="Enter nationality" id="nationality" value="<?php echo $row['nationality'];?>" name="nationality" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Join Date</span>
                            <input type="date" placeholder="Enter join date" id="joinDate" value="<?php echo $row['joinDate'];?>" name="joinDate" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Email</span>
                            <input type="email" placeholder="Enter email" id="contactInfo" value="<?php echo $row['contactInfo'];?>" name="contactInfo" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Ship ID</span>
                            <input type="number" placeholder="Enter ship ID" id="shipID" value="<?php echo $row['shipID'];?>" name="shipID" required>
                        </div>
                
                        <div class="input-box">
                            <span class="details">Crew Image</span>
                            <input type="file" accept=".jpg,.jpeg,.png" id="crewImg" name="crewImg" required>
                        </div>
            </div>
            <div class="button">
                        <input type="submit" class="btn" name="update_crew" value="update member of crew">
                        <a href="crew_admin.php">go back</a>
            </div>
            </form>
            <?php };?>
        </div>
</div>

</body>
</html>