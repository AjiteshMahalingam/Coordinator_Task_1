<?php 
    include("db_connect.php");

    date_default_timezone_set('Asia/Kolkata');
    $date = date('d-m-Y');
    $time = date('h:i:s a');
    
    $sql = "SELECT * FROM receipt";
    $result = mysqli_query($conn, $sql);
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    session_start();
    $total = $_SESSION['total'];

    if(isset($_POST["print"])){
        $total *=1.05;
        $sql = "INSERT INTO orders (Price) VALUES ($total)";
        if(mysqli_query($conn, $sql)){
            $sql = "SELECT * FROM orders ORDER BY ReceiptID DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $last = mysqli_fetch_assoc($result);
            $_SESSION['lastid'] = $last['ReceiptID'];
            header("Location: receipt.php");
        }else{
            echo 'QUERY ERROR : '. mysqli_error($conn);
        }
        $sql = "DELETE FROM receipt";
        if(mysqli_query($conn, $sql)){
            $sql = "ALTER TABLE receipt AUTO_INCREMENT=1";
            if(mysqli_query($conn, $sql)){
                //echo "Auto increment resetted.";
            }else{
                echo "QUERY ERROR : " . mysqli_error($conn);
            }
            header("Location: index.php");
        }else{
            echo "QUERY ERROR : " . mysqli_error($conn);
        }
    }
    if(isset($_POST["back"])){
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Frozen Bottle</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <link rel="stylesheet" href="receipt_styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <div class="container mt-5" style="background-color: rgba(255, 255, 255, 0.5); padding: 15px 10px; border-radius: 10px;">
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
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <div class="justify-content-end">
                <table class="table table-borderless">
                    <tr><td>Total       : </td><td><?php echo htmlspecialchars($total);?></td></tr>
                    <tr><td>GST         : </td><td>5%</td></tr>
                    <tr class="font-weight-bold" style="border:2px solid black; border-radius:10px" ><td>GRAND TOTAL :</td>
                        <td ><?php echo htmlspecialchars($total*1.05);?></td></tr>
                </table>
            </div>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >        
                <input type="submit" name="back" value="Back" class="btn btn-dark">
                <input type="submit" name="print" value="Print" class="btn btn-success">
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    </body>

</html>