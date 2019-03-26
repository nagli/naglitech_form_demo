<?php
$arrData = $_POST;

/* strip any tags of the input */
foreach ($arrData as $key => $value) {
    $arrData[$key] = XXSClean($value);
}
$arrData['txtEmail'] = emailCheck($arrData['txtEmail']);
if (!isset($arrData['chkCookie'])) { $arrData['chkCookie'] = 0; }

//var_dump($arrData);
require_once("./class/Save.php");
$SAVE = new Save();
if ($SAVE->saveContent($arrData)) {
    header("Location:./success.html");
} else {
    //printf("Error: %s", $SAVE->getError());
    header("Location:./failed.html");
}


function XXSClean($str)
{
    return strip_tags($str);
}
function emailCheck($email)
{
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    } else {
        return '';
    }
}

  
?>
