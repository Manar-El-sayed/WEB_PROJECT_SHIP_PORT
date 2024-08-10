<?php
@include 'connect.php';
$arrivalID = $_GET['edit'];

if(isset($_POST['update_arrival'])){
    $shipID = $_POST['shipID'];
    $captainName = $_POST['captainName'];
    $arrivalDate = $_POST['arrivalDate'];
    $departureDate = $_POST['departureDate'];
    $cargoDescription = $_POST['cargoDescription'];
    $arrivalStatus = $_POST['arrivalStatus'];
    $berthAllocated = $_POST['berthAllocated'];
    $shipImg = $_FILES['shipImg']['name'];  
    $shipImg_tmp_name = $_FILES['shipImg']['tmp_name'];
    $shipImg_folder = 'images/' . $shipImg;

    if (empty($captainName) || empty($arrivalDate) || empty($departureDate) || empty($cargoDescription) || empty($arrivalStatus) || empty($shipImg) || empty($shipID)) {
        $message[] = 'Please fill out all fields.';
    } else {
        $check_ship = mysqli_query($conn, "SELECT * FROM ships WHERE shipID = '$shipID'");
        
        if (mysqli_num_rows($check_ship) > 0) {
            $update = "UPDATE shipArrivals SET captainName='$captainName', arrivalDate='$arrivalDate', departureDate='$departureDate', cargoDescription='$cargoDescription', arrivalStatus='$arrivalStatus', berthAllocated='$berthAllocated', shipID='$shipID', shipImg='$shipImg' WHERE arrivalID = $arrivalID";
            
            $upload = mysqli_query($conn, $update);

            if ($upload) {
                move_uploaded_file($shipImg_tmp_name, $shipImg_folder);
                $message[] = 'ship arrival updated successfully.';
            } else {
                $message[] = 'Could not update this ship arrival.';
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
    <title>ship arrival update</title>
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/all.min.css">
    <!-- css link  -->
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="admin-crew centered">
<div class="container ">
    <?php
    $select = mysqli_query($conn, "SELECT * FROM shipArrivals WHERE arrivalID = $arrivalID");
    // $editcrewID = isset($_GET['edit']) ? $_GET['edit'] : null;
    while($row = mysqli_fetch_assoc($select)){
        ?>

            <div class="title">update ship arrival</div>
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
                            <span class="details">captain Name</span>
                            <input type="text" placeholder="Enter the captain name" id="captainName" value="<?php echo $row['captainName']; ?>" name="captainName" required>
                        </div>
                        <div class="input-box">
                            <span class="details">arrival date</span>
                            <input type="date" placeholder="Enter arrival date" id="arrivalDate" value="<?php echo $row['arrivalDate'];?>" name="arrivalDate" required>
                        </div>
                        <div class="input-box">
                            <span class="details">departure date</span>
                            <input type="date" placeholder="Enter departure date" id="departureDate" value="<?php echo $row['departureDate'];?>" name="departureDate" required>
                        </div>
                        <div class="input-box">
                            <span class="details">cargo description </span>
                            <input type="text" placeholder="Enter cargo description" id="cargoDescription" value="<?php echo $row['cargoDescription'];?>" name="cargoDescription" required>
                        </div>
                        <div class="input-box">
                            <span class="details">arrival status</span>
                            <input type="text" placeholder="Enter arrival status" id="arrivalStatus" value="<?php echo $row['arrivalStatus'];?>" name="arrivalStatus" required>
                        </div>
                        <div class="input-box">
                            <span class="details">berth allocated</span>
                            <input type="text" placeholder="Enter berth allocated" id="berthAllocated" value="<?php echo $row['berthAllocated'];?>" name="berthAllocated" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Ship ID</span>
                            <input type="number" id="shipID" value="<?php echo $row['shipID'];?>" name="shipID" required>
                        </div>
                
                        <div class="input-box">
                            <span class="details">ship Image</span>
                            <input type="file" accept=".jpg,.jpeg,.png" id="shipImg" name="shipImg" required>
                        </div>
            </div>
            <div class="button">
                        <input type="submit" class="btn" name="update_arrival" value="update ship arrival">
                        <a href="add_arrivals.php">go back</a>
            </div>
            </form>
    <?php };?>

        </div>
</div>

</body>
</html>