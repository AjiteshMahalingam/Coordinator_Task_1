<?php 
    include('db_connect.php');
    
    $id = $title = $qnty = $price = "";
    $total = 0;
    $i = 0;
    
    date_default_timezone_set('Asia/Kolkata');
    $date = date('d-m-Y');
    $time = date('h:i:s a');
    
    $items = array();
    $errors = array("id" => '', "qnty" => '');
    
    $sql = "SELECT * FROM receipt";
    $result = mysqli_query($conn, $sql);
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    session_start();
    
    
    if(isset($_POST['reset'])){
        $sql = "DELETE FROM receipt";
        if(mysqli_query($conn, $sql)){
            $_SESSION['sno'] = 0;
            //echo "Resetted";
            $items = array();
        }else{
            echo "QUERY ERROR : " . mysqli_error($conn);
        }
    }
    
    if(isset($_POST['confirm'])){
        header("Location: receipt.php");
        
    }
    
    if(isset($_POST['delete'])){
		$id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
		$sql = "DELETE FROM receipt WHERE Num = $id_to_delete";
		if(mysqli_query($conn, $sql)){
			$_SESSION['sno'] -= 1;
		} else {
			echo 'QUERY ERROR : '. mysqli_error($conn);
		}
        $sql = "SELECT * FROM receipt";
        $result = mysqli_query($conn, $sql);
        if($result){
            $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }else{
            echo "QUERY ERROR : " . mysqli_error($conn);
        }

	}
    
    if(isset($_POST['submit'])){
        if(empty($_POST['id'])){
            $errors['id'] = "*Required";
        }else{
            $id = $_POST['id'];
        }
        if(empty($_POST["qnty"])){
            $errors['qnty'] = "*Required";
        }else{
            $qnty = $_POST['qnty'];
            if ($qnty <= 0){
                $errors['qnty'] = "*Enter atleast 1 qnty.";
            }
        }
        if(array_filter($errors)){
            //echo errors
        }else{
            $id = mysqli_real_escape_string($conn, $_POST["id"]);
            $sql = "SELECT * FROM menu WHERE MenuID = '$id'";
            //echo $sql;
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) == 0){
                $errors['id'] = "*Enter a valid MenuID.";
            }else{
            $item = mysqli_fetch_assoc($result);
            //print_r($item);
            $title = $item['Title'];
            $price = $item['Price']*$qnty;
            $num = $_SESSION['sno'] ?? 0;
            $sql = "INSERT INTO receipt VALUES ($num+1 ,'$id', '$title', $qnty, $price)";
            $_SESSION['sno'] = $num + 1;
            if(mysqli_query($conn, $sql)){
                $id = $title = $qnty = $price = "";
            } else{
                echo "QUERY ERROR : " . mysqli_error($conn);
            }

            $sql = "SELECT * FROM receipt";
            $result = mysqli_query($conn, $sql);
            if($result){
                $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
            }else{
                echo "QUERY ERROR : " . mysqli_error($conn);
            }
            mysqli_free_result($result);
            mysqli_close($conn);
        }
        }
    }
    
    

?>
<!DOCTYPE html>
<html>
<head>
    <title>Frozen Bottle</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        function addCart(){
            swal({
                title:'Added to Cart',
                icon:'success'
            });
        }
    </script>
</head>
<body>
    <div style="background-color: rgba(255, 255, 255, 0.4);"><img src="Images/logo.png" id="logo" height=150px ></div>
    <div class="background"></div>
    <nav class="navbar navbar-toggleable-md navbar-expand-lg navbar-default navbar-light" style="background-color: rgba(255, 255, 255, 0.5);">
        <div class="container">
            <button class="navbar-toggler text-dark" data-toggle="collapse" data-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <div class="navbar-nav" style="margin: 0 auto;">
                    <a class="nav-item nav-link text-dark" href="#" >Home</a>
                    <a class="nav-item nav-link text-dark" href="#">About</a>
                    <a class="nav-item nav-link text-dark" href="#">Menu</a>
                    <a class="nav-item nav-link text-dark" href="#">Contact</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container" style="border-radius: 10px;">
        <div class="row">
        <div class="col-lg-4 mt-5" id="add-to" style="border-right: 2px solid black; border-radius:10px;">
            <h2 class="display-5 text-center">ADD TO CART</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <label>MenuID : </label>
                    <input type="text" class="form-control" name="id" value="<?php echo htmlspecialchars($id)?>" >
                    <label class="text-danger"><?php echo htmlspecialchars($errors['id']); ?></label>
                </div>
                <div class="form-group">
                    <label>Quantity : </label>
                    <input type="number" class="form-control" min="1" name="qnty" value="<?php echo htmlspecialchars($qnty)?>">
                    <label class="text-danger"><?php echo htmlspecialchars($errors['qnty']); ?></label>
                </div>
                <input type="submit" value="Add to Cart" class="btn btn-dark text-center" name="submit" onClick="addCart()">
            </form>
        </div>
        <div class="col-lg-8 justify-content-end mt-5" id="bill" style="border-radius:10px;">
            <h2 class="display-5 text-center">RECEIPT</h2>
            <p>Receipt No : <?php echo ($_SESSION['lastid'] ?? 0)+1; ?></p> 
            <p>Date : <?php echo $date; ?> </p>
            <p>Time : <?php echo $time; ?> </p>
            <table class="table table-hover table-bordered table-striped table-dark" style="border-radius:10px;">
                <thead class="thead-dark">
                    <tr><td>S.No</td><td>MenuID</td><td>Title</td><td>Qnty</td><td>Price</td></tr>                    
                </thead>
                <tbody>
                    <?php foreach($items as $entry): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entry['Num']);?></td>
                        <td><?php echo htmlspecialchars($entry['MenuID']);?></td>
                        <td><?php echo htmlspecialchars($entry['Title']);?></td>
                        <td><?php echo htmlspecialchars($entry['Qnty']);?></td>
                        <td><?php echo htmlspecialchars($entry['Price']);?></td>
                        <td><form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="id_to_delete" value="<?php echo $entry['Num']; ?>">
				        <input type="submit" name="delete" value="Delete" class="btn btn-light">
                        </form></td>
                        <?php $total += $entry['Price'];?>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <div class="justify-content-end">
                <table class="table table-borderless font-weight-bold " style="border:2px solid black; border-radius:10px">
                    <tr><td>Total       : </td>
                        <td class="justify-content-end"><?php echo htmlspecialchars($total); $_SESSION['total'] = $total; ?></td></tr>
                </table>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >        
                    <input type="submit" name="reset" value="Reset" class="btn btn-dark">
                    <input type="submit" name="confirm" value="Confirm" class="btn btn-success">
                </form>                
            </div>

        </div>
        </div>
    </div>
    <div class="container-fluid text-center mt-5" style="background-color: rgba(255, 255, 255, 0.5); padding: 20px; position: relative; ">
            <div class="i-bar" style="display: flex; flex-direction: row; flex-wrap: wrap; justify-content:center; margin-bottom: 2em;">
                <a class="fa fa-facebook " href="#" style="border: none; text-decoration: none;  margin: 0em 1em; color:black; font-size: xx-large;"></a>
                <a class="fa fa-instagram" href="#" style="border: none; text-decoration: none;  margin: 0em 1em; color:black; font-size: xx-large;"></a>
                <a class="fa fa-envelope " href="#" style="border: none; text-decoration: none;  margin: 0em 1em; color:black; font-size: xx-large;"></a>
            </div>
            <p class="credit" style="font-size: 15px; font-stretch: 2px; text-align: center; color: black;">© FROZEN BOTTLE</p>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>
</html>