<?php

  require_once 'connection.php';

  $sql = "SELECT * FROM products WHERE category = 'playstation'";
  $all_product = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Ecommerce Website</title>
</head>
<body>
    <?php
        include 'header.php';

   ?>

   <main>
       <?php
          while($row = mysqli_fetch_assoc($all_product)){
       ?>
       <div class="card">
    <div class="image">
        <a href="product.php?id=<?php echo $row['product_id']; ?>">
            <img src="<?php echo $row['image']; ?>" alt="">
        </a>
    </div>
    <div class="caption">
        <p class="product_name"><?php echo $row['product_name']; ?></p>
        <p class="quantity">
                        <i class="bi bi-plus-square-fill"></i>
                        <?php echo $row['quantity']; ?>
        <p class="price"><b>$<?php echo $row['price']; ?></b></p>
        <p class="rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </p>
        <?php if ($row['discount'] > 0) { ?>
                        <p class="discount"><b><del>$<?php echo $row['discount']; ?></del></b></p>
                    <?php } ?>
    </div>
    <button class="add" data-id="<?php echo $row['product_id']; ?>">Add to cart</button>
</div>

       <?php

          }
     ?>
   </main>
   <script>
       var product_id = document.getElementsByClassName("add");
       for(var i = 0; i<product_id.length; i++){
           product_id[i].addEventListener("click",function(event){
               var target = event.target;
               var id = target.getAttribute("data-id");
               var xml = new XMLHttpRequest();
               xml.onreadystatechange = function(){
                   if(this.readyState == 4 && this.status == 200){
                       var data = JSON.parse(this.responseText);
                       target.innerHTML = data.in_cart;
                       document.getElementById("badge").innerHTML = data.num_cart + 1;
                   }
               }

               xml.open("GET","connection.php?id="+id,true);
               xml.send();
            
           })
       }

   </script>
</body>
</html>