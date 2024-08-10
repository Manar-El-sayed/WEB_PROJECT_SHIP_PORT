<?php
@include 'connect.php';
$shipID = $_GET['edit'];
if(isset($_POST['update_ship'])){
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
    }
            $update = "UPDATE ships SET shipName='$shipName', shipType='$shipType', maxCapacity='$maxCapacity', registrationDate='$registrationDate', registrationDate='$registrationDate', shipImg='$shipImg'  WHERE shipID=$shipID";
            
            $upload = mysqli_query($conn, $update);

            if ($upload) {
                move_uploaded_file($shipImg_tmp_name, $shipImg_folder);
                $message[] = 'ship updated successfully.';
            } else {
                $message[] = 'Could not update this ship.';
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
    $select = mysqli_query($conn, "SELECT * FROM ships WHERE shipID = $shipID");
    while($row = mysqli_fetch_assoc($select)){
        ?>

            <div class="title">update ship</div>
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
                            <input type="text" placeholder="Enter the name of ship" id="shipName" value="<?php echo $row['shipName'];?>" name="shipName" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Role</span>
                            <input type="text" placeholder="Enter ship type" id="shipType" value="<?php echo $row['shipType'];?>" name="shipType" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Nationality</span>
                            <input type="text" placeholder="Enter nationality" id="maxCapacity" value="<?php echo $row['maxCapacity'];?>" name="maxCapacity" required>
                        </div>
                        <div class="input-box">
                            <span class="details">registration Date</span>
                            <input type="text" placeholder="Enter registration date" id="registrationDate" value="<?php echo $row['registrationDate'];?>" name="registrationDate" required>
                        </div>
                        <div class="input-box">
                            <span class="details">owner info</span>
                            <input type="text" placeholder="Enter owner info" id="ownerInfo" value="<?php echo $row['ownerInfo'];?>" name="ownerInfo" required>
                        </div>
                
                        <div class="input-box">
                            <span class="details">ship Image</span>
                            <input type="file" accept=".jpg,.jpeg,.png" id="shipImg" name="shipImg" required>
                        </div>
            </div>
            <div class="button">
                        <input type="submit" class="btn" name="update_ship" value="update ship">
                        <a href="ships_admin.php">go back</a>
            </div>
            </form>
    <?php };?>

        </div>
</div>

</body>
</html>