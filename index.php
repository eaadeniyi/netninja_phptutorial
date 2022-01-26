<?php

    //connection to the database from file in config
    include("config/db_connect.php");

    //write query for all content in the pizzas table
        $sql = 'SELECT Title, Ingredients, Id FROM pizzas ORDER BY created_at';

    //make query and get result
        $result = mysqli_query($conn, $sql);

    //fetch the resulting rows as an associative array
        $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //free result from memory
        mysqli_free_result($result);

    //close connection to the database
        mysqli_close($conn);

        // print_r($pizzas);

    // how to explode a string into an array
    //explode("," , $pizzas[0]['Ingredients']);
?>


<!DOCTYPE html>
<html lang="en">


<?php include("templates/header.php"); ?>
<h4 class="center grey-text">Pizzas!</h4>
<div class="container">
        <div class="row"><?php foreach($pizzas as $pizza):?>
         
            <div class="col s6 md3">
            <div class="card z-depth-0">
                <img src="img/pizza.svg" alt="Pizza Image" class="pizza">
                <div class="card-content center">
                    <!-- outputting user input  -->
                    <h6><?php echo htmlspecialchars($pizza['Title']);  ?></h6>
                    <ul><?php foreach(explode(',' , $pizza['Ingredients']) as $ing):?>

                        <li> <?php echo htmlspecialchars($ing); ?></li>
                   <?php endforeach; ?></ul>
                </div>
                <div class="card-action right-align">  
                <a href="details.php?id=<?php echo $pizza['Id']; ?>" class="brand-text"> More Info</a>
                </div>
            </div>
            </div>

        <?php endforeach; ?></div>
</div>

<?php include("templates/footer.php"); ?>

</html>