<?php

   //connection to the database from file in config
   include("config/db_connect.php");

    //initializing our variable to be empty strings'
    $title = $email = $ingredients = '';

    //displaying the various errors in the form.
    $errors = array('email' => '', 'title' => '', 'ingredients' => '');

    // if(isset($_GET['submit'])){
    //     echo $_GET['email'];
    //     echo $_GET['title'];
    //     echo $_GET['ingredients'];
    // }


    //using the post method
    // if(isset($_POST['submit'])){
    //     echo htmlspecialchars($_POST['email']);
    //     echo htmlspecialchars($_POST['title']);
    //     echo htmlspecialchars($_POST['ingredients']);
    // }

    //form validation 
    if(isset($_POST['submit'])){
             //check email
             if(empty($_POST['email'])){
                $errors['email'] = "An e-mail is required .<br/>";
            }//using php filter to check email
            else{
                $email = $_POST['email'];
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                   $errors['email'] = "A valid email address is required.";
                }
            }

        //check title value using regex
        if(empty($_POST['title'])){
            $errors ['title'] = "A title is required .<br/>";
        } else{
			$title = $_POST['title'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
				$errors ['title'] = 'Title must be letters and spaces only';
			}
		}

        //check ingredients value using regex
        if(empty($_POST['ingredients'])){
            $errors ['ingredients'] = "At least one ingredient is required .<br/>";
        }else{
			$ingredients = $_POST['ingredients'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
				$errors ['ingredients'] = 'Ingredients must be a comma separated list';
			}
		}

            if(array_filter($errors)){
                // echo "There are errors in the form";
            }else{
            
                //saving the data to the databse
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

                //creating sql string that will add the data to the database
                $sql = "INSERT INTO pizzas (Title, Email, Ingredients) VALUES ('$title','$email', '$ingredients')";
                
                //saving to the database and check
            if(mysqli_query($conn, $sql)){
                //success then we should redirect them to the index page
                header('Location: index.php');
            }else{
                echo 'query error: ' . mysqli_error($conn);
            }
            }
            
     //end of POST check 
    }
         
?>




<!DOCTYPE html>
<html lang="en">


<?php include("templates/header.php"); ?>

<section class="container grey-text">
    <h4 class="center">
        Add a Pizza
    </h4>
    <form action="add.php" class="white" method="POST">
        <label for="E-mail">Your E-mail:</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"><?php echo $errors['email']; ?></div>

        <label for="E-mail">Pizza Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
        <div class="red-text"><?php echo $errors['title']; ?></div>

        <label for="E-mail">Ingredients (comma separated):</label>
        <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
        <div class="red-text"><?php echo $errors['ingredients']; ?></div>

        <div class="center">
            <input type="submit" name="submit" value="Submit" class = "btn brand z-depth-0">
        </div>
    </form>
</section>


<?php include("templates/footer.php"); ?>

</html>