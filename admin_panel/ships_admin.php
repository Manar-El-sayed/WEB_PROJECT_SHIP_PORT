<?php
@include 'connect.php';

if (isset($_POST['add_ship'])) {
    $shipName = $_POST['shipName'];
    $shipType = $_POST['shipType'];
    $maxCapacity = $_POST['maxCapacity'];
    $registrationDate = $_POST['registrationDate'];
    $ownerInfo = $_POST['ownerInfo'];
    $shipImg = $_FILES['shipImg']['name'];  
    $shipImg_tmp_name = $_FILES['shipImg']['tmp_name'];
    $shipImg_folder = 'images/' . $shipImg;

    if (empty($shipName) || empty($shipType) || empty($maxCapacity) || empty($registrationDate) || empty($ownerInfo) || empty($shipImg)) {
        $message[] = 'Please fill out all fields.';
    } else {
            $insert = "INSERT INTO ships(shipName, shipType, maxCapacity, registrationDate, ownerInfo, shipImg) VALUES('$shipName','$shipType','$maxCapacity', '$registrationDate', '$ownerInfo', '$shipImg')";
            $upload = mysqli_query($conn, $insert);

            if ($upload) {
                move_uploaded_file($shipImg_tmp_name, $shipImg_folder);
                $message[] = 'New ship added successfully.';
            } else {
                $message[] = 'Could not add this ship .';
            }
        }
    }


if (isset($_GET['delete'])) {
    $shipID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM ships WHERE shipID = $shipID");
    header('location: ships_admin.php');
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
             <div class="title">Add ship </div>
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
                             <span class="details">ship Name</span>
                             <input type="text" placeholder="Enter the name of a ship" id="shipName" name="shipName" required>
                         </div>
                         <div class="input-box">
                             <span class="details">ship type</span>
                             <input type="text" placeholder="Enter ship type" id="shipType" name="shipType" required>
                         </div>
                         <div class="input-box">
                             <span class="details">max capacity</span>
                             <input type="text" placeholder="Enter max capacity" id="maxCapacity" name="maxCapacity" required>
                         </div>
                         <div class="input-box">
                             <span class="details">registration date</span>
                             <input type="date" placeholder="Enter registration date" id="registrationDate" name="registrationDate" required>
                         </div>
                         <div class="input-box">
                             <span class="details">owner info</span>
                             <input type="text" placeholder="Enter owner info" id="ownerInfo" name="ownerInfo" required>
                         </div>
                         <div class="input-box">
                             <span class="details">ship Image</span>
                             <input type="file" accept=".jpg,.jpeg,.png" id="shipImg" name="shipImg" required>
                         </div>
             </div>
             <div class="button">
                         <input type="submit" name="add_ship" value="Add ship">
             </div>
             </form>
         </div>
     </div>
             <?php
            $select = mysqli_query($conn, "SELECT * FROM ships");
             ?>
              <div class="crew-display">
                 <table class="crew-display-table">
                     <thead>
                         <tr>
                             <th>ship image</th>
                             <th>ship name</th>
                             <th>ship type</th>
                             <th>max capacity</th>
                             <th>registration date</th>
                             <th>owner info</th>
                             <th>action</th>
                         </tr>
                     </thead>
                     <?php
                    while($row = mysqli_fetch_assoc($select)){
                        ?>
                        <tr>
                           <td><img src="images/<?php echo $row['shipImg'];?>" height="100" alt=""></td>
                           <td><?php echo $row['shipName'];?></td>
                           <td><?php echo $row['shipType'];?></td>
                           <td><?php echo $row['maxCapacity'];?></td>
                           <td><?php echo $row['registrationDate'];?></td>
                           <td><?php echo $row['ownerInfo'];?></td>
                           <td>
                               <a href="ships_update.php?edit=<?php echo $row['shipID'];?>" class="btn"><i class="fas fa-edit"></i>edit</a>
                               <a href="ships_admin.php?delete=<?php echo $row['shipID'];?>" class="btn"><i class="fas fa-trash"></i>delete</a>
                           </td>
                       </tr>
                       <?php };?>
               </table>

              </div>
     </div>
    
 </body>
</html>