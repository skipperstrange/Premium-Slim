<?php

function connect()
{
    $con=mysqli_connect('localhost','root','root','vanguas2_homeprehensive');
    if($con === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    return $con;
}