<?php
// connect with data path
$conn = mysqli_connect("localhost","root","","shop");

$message = null;
$count = 1;
// create
if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $insert = "INSERT INTO `products` VALUES (NULL , '$name' , $price , '$category')";

    $i = mysqli_query($conn,$insert);

    if ($i) {
        $message = "Insert Successfully";
    }
}


// Read
$select = "SELECT * FROM `products`";
$s = mysqli_query($conn , $select);


// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $remove = "DELETE FROM `products` WHERE id=$id";
    $d = mysqli_query($conn , $remove);

    header("location:index.php");
}

// Edit
$name = "";
$price = "";
$category = "";

$update = false;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $edit = "SELECT * FROM `products` WHERE id=$id";
    $oneRow = mysqli_query($conn , $edit);
    $rowData = mysqli_fetch_assoc($oneRow);

    $name = $rowData['name'];
    $price = $rowData['price'];
    $category = $rowData['category'];

    
   

    $update = true;


    if(isset($_POST['update'])){
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        $up = "UPDATE products SET name = '$name' , price=$price , category='$category' WHERE id=$id";
        mysqli_query($conn , $up);

        header("location:index.php");
    }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./asset/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./asset/css/all.min.css">
    <link rel="stylesheet" href="./asset/css/main.css">
</head>
<body>
    

<?php if($update) : ?>
    <h1 class="text-center display-1 text-danger">Update Product <?= $name?></h1>
    <?php else : ?>
        <h1 class="text-center display-1 text-info">Create New Product</h1>
        <?php endif; ?>


    <div class="container col-6  my-5">

    <?php if ($message != null) : ?>
    <div class="alert alert-success text-center">
         <h5> <?= $message ?> </h5>
    </div>
    <?php endif ?>

        <div class="card">
            <div class="card-body">
                <form method="post">
                    <div class="form-group ">
                        <label>Name</label>
                        <input type="text" name="name" value="<?= $name ?>"  class="form-control my-3">
                    </div>

                    
                    <div class="form-group  my-3">
                        <label>Price</label>
                        <input type="number" name="price" value="<?= $price ?>" class="form-control">
                    </div>

                    
                    <div class="form-group  my-3">
                        <label>Category</label>
                        <select name="category"  class="form-control">
                            <?php if ($update) : ?>
                            <option value="<?=$category?>"><?=$category?></option>
                            <?php endif; ?>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Kids">Kids</option>
                        </select>
                    </div>

                    <?php if($update) : ?>
                        <div class="d-grid">
                        <button class="btn btn-warning" name="update">Update</button>
                        </div>
                    <?php else: ?>
                            <div class="d-grid">
                              <button class="btn btn-success" name="send">Create</button>
                            </div>
                    <?php endif; ?>
                    

                    
                        
                   

                </form>
            </div>
        </div>
    </div>




<?php if (!$update) : ?>
    <h1 class="text-center display-1 text-info">List Products</h1>
    <div class="container col-6 mt-5">
        <div class="card">
            <div class="card-body">
                <table class="table table-dark">
                    <tr class="text-center text-primary">
                        <th>Nu</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th colspan="3">Action</th>
                    </tr>

                    <?php foreach($s as $items) : ?>

                        <tr class="text-center">
                            <th> <?= $count++ ?> </th>
                            <th> <?= $items['id'] ?> </th>
                            <th> <?= $items['name'] ?> </th>
                            <th> <?= $items['price'] ?> </th>
                            <th> <?php if ($items['category'] == 'Male') { ?> 
                            <i class="fa-solid fa-mars text-primary"></i>

                            <?php }elseif ($items['category'] == 'Female') {  ?>
                                <i class="fa-solid fa-venus text-danger"></i>
                                <?php }else{ ?>
                                    <i class="fa-solid fa-child-reaching text-info"></i>
                                <?php } ?>
                        </th>

                            <th> <a title="Edit" href="?edit=<?= $items['id'] ?>"><i class="fa-solid fa-pen-to-square text-warning"></i></a> </th>
                            <th> <a onclick="return confirm('Are You Sure')" title="Delete" href="?delete=<?= $items['id'] ?>"><i class="fa-solid fa-trash-can text-danger"></i></a> </th>
                        </tr>

                        <?php endforeach; ?>

                </table>

            </div>
        </div>
    </div>

    <?php endif; ?>



<script src="asset/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>