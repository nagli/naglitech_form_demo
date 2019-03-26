<?php
require_once('./config/config.php');
class Save
{
    private $db = DB;
    private $dbHost = DB_HOST;
    private $dbUser = DB_USER;
    private $dbPassword = DB_PASSWORD;
    private $passwordToken = PASSWORD_TOKEN;
    private $error = "";
    
    public function saveContent(array $content)
    {
        $dateTime = date("Y-m-d H:i:s");
        $db = $this->connectDB();
        $sql = "INSERT INTO formContent  
        (first, last, address, address2, city, state, zip, email, password, fruit, cookie, created)
        VALUE(:first, :last, :address, :address2, :city, :state, :zip, :email, AES_ENCRYPT(:password, '".$this->passwordToken."'), :fruit, :cookie, :created)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first', $content['txtFirst'], PDO::PARAM_STR);
        $stmt->bindParam(':last', $content['txtLast'], PDO::PARAM_STR);
        $stmt->bindParam(':address', $content['txtAddress'], PDO::PARAM_STR);
        $stmt->bindParam(':address2', $content['txtAddress2'], PDO::PARAM_STR);
        $stmt->bindParam(':city', $content['txtCity'], PDO::PARAM_STR);
        $stmt->bindParam(':state', $content['txtState'], PDO::PARAM_STR);
        $stmt->bindParam(':zip', $content['txtZip'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $content['txtEmail'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $content['txtPassword'], PDO::PARAM_STR);
        $stmt->bindParam(':fruit', $content['rdoFruit'], PDO::PARAM_STR);
        $stmt->bindParam(':cookie', $content['chkCookie'], PDO::PARAM_INT);
        $stmt->bindParam(':created', $dateTime, PDO::PARAM_STR);
        
        try { 
            $stmt->execute();
            return true; 
        } catch(PDOExecption $e) {  
            //printf("Error!: " . $e->getMessage() . "</br>");
            return false; 
        } 
    }
    public function getError()
    {
        return $this->error;
    }
    private function connectDB()
    {
        try {
        $db = new PDO("mysql:host={$this->dbHost};dbname={$this->db}", $this->dbUser, $this->dbPassword);
        } catch (PDOException $e) {
            //print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $db;    
    }
} /* end of class */  
?>
