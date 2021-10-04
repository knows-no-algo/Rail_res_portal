<?php

include('functions.php');


if(isAdmin()){
    header('location: admin/home.php');
}
else if(isUser()){
    header('location: welcome.php');
}

else{
    header('location: index.php');
}

?>