<?php 
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );

    ini_set('sendmail_from', 'caritas.org.mx');
    $from = "himanshu.u@crestinfosystems.com";
    $to = "himanshu.u@crestinfosystems.com";
    $subject = "PHP Mail Test script";
    $message = "This is a test to check the PHP Mail functionality";
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    echo "Test email sent";
?>