<?php
    require_once "auth.php";
    /**All things to do with authorizing users**/

    function PostedCred($name){ //Check post variable integrity
        if (isset($_POST[$name]) && strlen($_POST[$name]) < 21 && strlen($_POST[$name]) > 3 && ctype_alnum($_POST[$name])){
            return true;
        }
        return false;
    }
    function Posted($name){
        if (isset($_POST[$name])){
            return true;
        }
        return false;
    }

    //Prevent SQL injection by cleaning all input variables
    function CleanString(&$string){
        $string = filter_var($string, FILTER_SANITIZE_STRING);
        return $string;
    }
    function CleanInt(&$int){
        $int = filter_var($int, FILTER_SANITIZE_NUMBER_INT);
        return $int;
    }
    function CleanURL(&$string){
        $string = filter_var($string, FILTER_SANITIZE_URL);
        return $string;
    }
    
    //Generate database object for MySQL
    function GenDBH($dbname, $username = auth::uname, $password = auth::passwd, $hostname = "localhost"){
        $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        //Throw exception on error
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }

    //Wrapper for PDO for binding integer values to request 
    function BindInt(&$stmt, $identifier, $int){
        $stmt->bindParam($identifier, $int, PDO::PARAM_INT);
    }
    
    //Wrapper for PDO for binding string to request
    function BindString(&$stmt, $identifier, $str){
        $stmt->bindParam($identifier, $str, PDO::PARAM_STR);
    }
     
    function login($username, $password)
    //Logs in user with username and password
        //Returns
        //-1 -> Invalid login
        //-2 -> Too many logins
        //User id -> successful login 
    {
        try{
            CleanString($username);
            CleanString($password);
            
            $dbh = GenDBH("cohort");
            $stmt = $dbh->prepare("SELECT uid, password FROM users WHERE name = :uname AND active = 1");

            BindString($stmt, ":uname", $username);

            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (password_verify($password, $data["password"])){
                return $data["uid"];
            }else{
                return -1;
            }
        }catch (Exception $e){
        }
        return -1;
    }
    function register($username, $password){
        try{
            CleanString($username);
            CleanString($password);
            
            $dbh = GenDBH("cohort");
            $stmt = $dbh->prepare("SELECT uid FROM users WHERE name = :uname AND active = 1");

            BindString($stmt, ":uname", $username);

            $stmt->execute();

            if ($stmt->fetchColumn() > 0){
                return -1;
            }
            
            $stmt = $dbh->prepare("INSERT INTO users (name, password) VALUES(:uname, :hashpass)");
            
            BindString($stmt, ":uname", $username);
            BindString($stmt, ":hashpass", password_hash($password, PASSWORD_DEFAULT));     

            $stmt->execute();
            return 1;
        }catch (Exception $e){
        }
        return -2;


        
    }
    function verify_captcha($key){
        try{
            $url = "https://www.google.com/recaptcha/api/siteverify";
            $data = [ 'secret' => '6Lfx7wgUAAAAAO1WyL_LvaecJZNB666fxoZDWkXl',
                'response' => $key,
                'remoteip' => $_SERVER['REMOTE_ADDR']  ];
            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data) 
                    ]
                ];
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            return json_decode($result)->success;  
        }catch (Exception $e){
            return false;
        }
    }
    function add_assignment($title, $details, $due, $url, $uid){
        try{
            CleanString($title);
            CleanString($details);
            CleanString($due);
            CleanURL($url); 
            CleanInt($uid);

            //Get database object
            $dbh = GenDBH("cohort");
            $stmt = $dbh->prepare("INSERT INTO assignments(name, details, due, url, created_uid) VALUES(:name, :details, :due, :url, :uid)");

            BindString($stmt, ":name", $title);
            BindString($stmt, ":details", $details);
            BindString($stmt, ":due", $due);
            BindString($stmt, ":url", $url);
            BindInt($stmt, ":uid", $uid);

            $stmt->execute();

        }catch (Exception $e){
        }
    }
    function get_active_assignments()
    //Gets all assignments with the active tag equalling 1
    {
        try{
            $dbh = GenDBH("cohort");
            $stmt = $dbh->prepare("SELECT rid, name, details, due, url FROM assignments WHERE active = 1 ORDER BY due");

            $stmt->execute();
            
            return $stmt->fetchAll(); 
        }catch(Exception $e){
        }
    } 
    function get_current_assignments($uid)
    //Gets all assignments due today or later after today
    {
        if ($uid == 0){
            return get_active_assignments();
        }
        try{
            CleanInt($uid);
            $dbh = GenDBH("cohort");
            $stmt = $dbh->prepare("SELECT rid, name, details, due, url FROM assignments WHERE active = 1 AND created_uid = :uid AND due >= CURDATE() ORDER BY due");
            BindInt($stmt, ":uid", $uid);

            $stmt->execute();
            
            return $stmt->fetchAll(); 
        }catch(Exception $e){
        }

    }
    function deactivate_assignment($rid){
         try{
            CleanString($rid);
            $dbh = GenDBH("cohort");
            $stmt = $dbh->prepare("UPDATE assignments SET active = 0 WHERE rid = :rid");
            BindInt($stmt, ":rid", $rid);

            $stmt->execute();
        }catch(Exception $e){
        }
       
    }
?>
