<?php
@include 'connect.php';

if (isset($_POST['add_arrival'])) {
    $shipID = $_POST['shipID'];
    // $portID = $_POST['portID'];
    $captainName = $_POST['captainName'];
    $arrivalDate = $_POST['arrivalDate'];
    $departureDate = $_POST['departureDate'];
    $cargoDescription = $_POST['cargoDescription'];
    $arrivalStatus = $_POST['arrivalStatus'];
    $berthAllocated = $_POST['berthAllocated'];
    $shipImg = $_FILES['shipImg']['name'];  
    $shipImg_tmp_name = $_FILES['shipImg']['tmp_name'];
    $shipImg_folder = 'images/' . $shipImg;

    if (empty($captainName) || empty($arrivalDate) || empty($departureDate) || empty($cargoDescription) || empty($arrivalStatus) || empty($shipImg)) {
        $message[] = 'Please fill out all fields.';
    } else {
        $check_ship = mysqli_query($conn, "SELECT * FROM ships WHERE shipID = '$shipID'");
        
        if (mysqli_num_rows($check_ship) > 0) {
            $insert = "INSERT INTO shipArrivals(captainName, arrivalDate, departureDate, cargoDescription, arrivalStatus, berthAllocated, shipImg, shipID) VALUES('$captainName','$arrivalDate','$departureDate', '$cargoDescription', '$arrivalStatus','$berthAllocated','$shipImg','$shipID')";
            $upload = mysqli_query($conn, $insert);

            if ($upload) {
                move_uploaded_file($shipImg_tmp_name, $shipImg_folder);
                $message[] = 'New ship arrival added successfully.';
            } else {
                $message[] = 'Could not add this ship arrival.';
            }
        } else{
            $message[] = 'Invalid ship ID.';
        }
    }
}

if (isset($_GET['delete'])) {
    $arrivalID = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM shiparrivals WHERE arrivalID = $arrivalID");
    header('location: add_arrivals.php');
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
             <div class="title">Add ship arrival</div>
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
                             <span class="details">Captain Name</span>
                             <input type="text" placeholder="Enter the name of a captain" id="captainName" name="captainName" required>
                         </div>
                         <div class="input-box">
                             <span class="details">Arrival Date</span>
                             <input type="date" placeholder="Enter arrival date" id="arrivalDate" name="arrivalDate" required>
                         </div>
                         <div class="input-box">
                             <span class="details">Departure Date</span>
                             <input type="date" placeholder="Enter Departure Date" id="departureDate" name="departureDate" required>
                         </div>
                         <div class="input-box">
                             <span class="details">Cargo Description</span>
                             <input type="text" placeholder="Enter cargo description" id="cargoDescription" name="cargoDescription" required>
                         </div>
                         <div class="input-box">
                             <span class="details">Arrival Status</span>
                             <input type="text" placeholder="Enter arrival status" id="arrivalStatus" name="arrivalStatus" required>
                         </div>
                         <div class="input-box">
                             <span class="details">Berth Allocated</span>
                             <input type="text" id="berthAllocated" name="berthAllocated" required>
                         </div>
                         <div class="input-box">
                             <span class="details">Ship ID</span>
                             <input type="number" id="shipID" name="shipID" required>
                         </div>
                         <div class="input-box">
                             <span class="details">ship Image</span>
                             <input type="file" accept=".jpg,.jpeg,.png" id="shipImg" name="shipImg" required>
                         </div>
             </div>
             <div class="button">
                         <input type="submit" name="add_arrival" value="Add ship arrival">
             </div>
             </form>
         </div>
     </div>
             <?php
            $select = mysqli_query($conn, "SELECT * FROM shiparrivals");
             ?>
              <div class="crew-display">
                 <table class="crew-display-table">
                     <thead>
                         <tr>
                             <th>ship image</th>
                             <th>captain name</th>
                             <th>arrival date</th>
                             <th>departure date</th>
                             <th>cargo description</th>
                             <th>arrival status</th>
                             <th>berth allocated</th>
                             <th>action</th>
                         </tr>
                     </thead>
                     <?php
                    while($row = mysqli_fetch_assoc($select)){
                        ?>
                        <tr>
                           <td><img src="images/<?php echo $row['shipImg'];?>" height="100" alt=""></td>
                           <td><?php echo $row['captainName'];?></td>
                           <td><?php echo $row['arrivalDate'];?></td>
                           <td><?php echo $row['departureDate'];?></td>
                           <td><?php echo $row['cargoDescription'];?></td>
                           <td><?php echo $row['arrivalStatus'];?></td>
                           <td><?php echo $row['berthAllocated'];?></td>
                           <td>
                               <a href="arrival_update.php?edit=<?php echo $row['arrivalID'];?>" class="btn"><i class="fas fa-edit"></i>edit</a>
                               <a href="add_arrivals.php?delete=<?php echo $row['arrivalID'];?>" class="btn"><i class="fas fa-trash"></i>delete</a>
                           </td>
                       </tr>
                       <?php };?>
               </table>

              </div>
     </div>
    
 </body>
</html>