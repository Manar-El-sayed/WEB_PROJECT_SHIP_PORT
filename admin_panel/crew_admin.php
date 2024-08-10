<?php
@include 'connect.php';

if (isset($_POST['add_crew'])) {
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
            $insert = "INSERT INTO crew(crewName, role, nationality, joinDate, contactInfo, crewImg, shipID) VALUES('$crewName','$role','$nationality','$joinDate','$email','$crewImg','$shipID')";
            $upload = mysqli_query($conn, $insert);

            if ($upload) {
                move_uploaded_file($crewImg_tmp_name, $crewImg_folder);
                $message[] = 'New member added successfully.';
            } else {
                $message[] = 'Could not add this member.';
            }
        } else {
            $message[] = 'Invalid ship ID.';
        }
    }
}

if (isset($_GET['delete'])) {
    $crewID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM crew WHERE crewID = $crewID");
    header('location: crew_admin.php');
}
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Admin page</title>
     <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/all.min.css">
     <!-- css link  -->
     <link rel="stylesheet" href="login.css">
 </head>
 <body class="crew">
 <div class="admin-crew">
     <div class="form-container">
     <div class="container">
             <div class="title">Add member of crew</div>
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
                             <span class="details">crew Name</span>
                             <input type="text" placeholder="Enter the name of ship" id="crewName" name="crewName" required>
                         </div>
                         <div class="input-box">
                             <span class="details">role</span>
                             <input type="text" placeholder="Enter ship type" id="role" name="role" required>
                         </div>
                         <div class="input-box">
                             <span class="details">nationality</span>
                             <input type="text" placeholder="Enter nationality" id="nationality" name="nationality" required>
                         </div>
                         <div class="input-box">
                             <span class="details">join Date</span>
                             <input type="date" placeholder="Enter join date" id="joinDate" name="joinDate" required>
                         </div>
                         <div class="input-box">
                             <span class="details">owner info</span>
                             <input type="email" placeholder="Enter email" id="contactInfo" name="contactInfo" required>
                         </div>
                         <div class="input-box">
                             <span class="details">Ship ID</span>
                             <input type="text" id="shipID" name="shipID" required>
                         </div>
                         <div class="input-box">
                             <span class="details">Crew Image</span>
                             <input type="file" accept=".jpg,.jpeg,.png" id="crewImg" name="crewImg" required>
                         </div>
             </div>
             <div class="button">
                         <input type="submit" name="add_crew" value="Add member of crew">
             </div>
             </form>
         </div>
     </div>
             <?php
            $select = mysqli_query($conn, "SELECT * FROM crew");
             ?>
              <div class="crew-display">
                 <table class="crew-display-table">
                     <thead>
                         <tr>
                             <th>crew image</th>
                             <th>name</th>
                             <th>role</th>
                             <th>nationality</th>
                             <th>join date</th>
                             <th>email</th>
                             <th>action</th>
                         </tr>
                     </thead>
                     <?php
                    while($row = mysqli_fetch_assoc($select)){
                        ?>
                        <tr>
                           <td><img src="images/<?php echo $row['crewImg'];?>" height="100" alt=""></td>
                           <td><?php echo $row['crewName'];?></td>
                           <td><?php echo $row['role'];?></td>
                           <td><?php echo $row['nationality'];?></td>
                           <td><?php echo $row['joinDate'];?></td>
                           <td><?php echo $row['contactInfo'];?></td>
                           <td>
                               
                               <a href="crew_update.php?edit=<?php echo $row['crewID'];?>" class="btn"><i class="fas fa-edit"></i>edit</a>
                               <a href="crew_admin.php?delete=<?php echo $row['crewID'];?>" class="btn"><i class="fas fa-trash"></i>delete</a>
                           </td>
                       </tr>
                       <?php };?>
               </table>

              </div>
     </div>
    
 </body>
</html>