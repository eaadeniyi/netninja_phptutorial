<?php

//include the database connect file
include('config/db_connect.php');

//checking for the value of the DELETE post array
if(isset($_POST['delete'])){
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
    $sql = "DELETE FROM pizzas WHERE Id=$id_to_delete";

    if(mysqli_query($conn, $sql)){
        //success
        header ('Location: index.php');

    }else{
        //failure
        echo 'query error: '. mysqli_query_error($conn);
    }
}

//check GET request Id Parameter
if(isset($_GET['id'])){

    // check to remove any mysql/sql special character that might be inputed into the url
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    //make sql that will be used to make query
    $sql = "SELECT * FROM pizzas WHERE Id = $id ";

    //get the query result
    $result = mysqli_query($conn, $sql);

    //fetch result in array format
    $pizza = mysqli_fetch_assoc($result);

    //freeing up the result and closing the connection
    mysqli_free_result($result);

    mysqli_close($conn);

}

?>

<!DOCTYPE html>
<html lang="en">

<?php include("templates/header.php"); ?>

<div class="container center grey-text">

    <?php if($pizza): ?>
        <h4><?php echo htmlspecialchars($pizza['Title']); ?></h4>
        <p> Created By: <?php echo htmlspecialchars($pizza['Email']); ?></p>
        <p><?php echo date($pizza['Created_at']); ?></p>
        <h5>Ingredients: </h5>
        <p><?php echo htmlspecialchars($pizza['Ingredients']); ?></p>
   
        <!-- DELETE FORM -->
        <form action="details.php" method="POST">
            <input type="hidden" name ="id_to_delete" value="<?php echo $pizza['Id'] ?>" >
            <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
        </form>
        <?php else: ?>
        <h5 class="red-text"> No such PIZZA exists!!!</h5>
    <?php endif; ?>
</div>

<?php include("templates/footer.php"); ?>
</html>