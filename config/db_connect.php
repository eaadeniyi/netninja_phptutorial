<?php

//connect to database
$conn = mysqli_connect('localhost', 'E.A.A', 'inumidun', 'pizza_project');
    
//checking for connection
    if(!$conn){
        echo 'Connection Error: '. mysqli_connect_error();
    }

?>