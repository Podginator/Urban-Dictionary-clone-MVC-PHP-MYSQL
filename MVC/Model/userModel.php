<?php

require_once ("Model.php");

class UserModel extends Model
{
	protected $defaultEntity = "UserEntity";

	public function AddUser($username, $password, $email)
    {
    	$hashedPass = password_hash($password, PASSWORD_DEFAULT);
    	$SQL = "INSERT INTO USER (username, passwordhash, email) VALUES (:username, :password, :email)";
    	$query = $this->database->prepare($SQL);
    	$param = array(':username'=>$username, ':password'=>$hashedPass, ":email"=>$email);

    	$query->execute($param);
    }

    public function GetUser($username)
    {
		return $this->Fetch("SELECT * FROM USER WHERE username = :value",array(":value" => $username),$this->defaultEntity);
    }

    public function ValidateRegistration($data, &$message=null)
    {
    	if(
    		strlen($data["username"]) == 0 ||
    		strlen($data["email"]) == 0 ||
    		strlen($data["password"]) == 0
    		)
    	{
    		$message = "Ensure you have filled out all areas.";
    		return false;

    	}

    	if($this->GetUser($data["username"]) != null)
    	{
    		$message = "Username Taken!";
    		return false;
    	}

    	if($data["password"] != $data["confirm"])
    	{
    		$message = "password's don't match";
    		return false;
    	}
    	else if(strlen($data["password"]) < 6)
    	{
    		$message = "Password needs to be greater than 6 characters";
    		return false;
    	}

    	if(!filter_var($data["email"], FILTER_VALIDATE_EMAIL))
    	{
    		$message = "Invalid Email";
    		return false;
    	}


    	$message = "Successfully Added User " . $data["username"];
    	return true;
    }

    static public function ValidateUser($db)
    {
		if(isset($_SESSION["user"])) {
			$query = $db->prepare("SELECT * FROM USER WHERE username = :value");
			$query->execute(array(":value" => $_SESSION["user"]));
			$user = $query->fetch();
		}
    	if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] && $user)
    	{
    		if(hash("sha256", $_SERVER['HTTP_USER_AGENT'].$user["passwordhash"]) == $_SESSION["login_string"])
    		{
    			return true;
    		}
			else
			{
				self::LogOut();
			}
    	}

    	return false;
    }

    static public function LogOut()
    {
		if(isset($_SESSION["user"]))
		{
			session_destroy();
		}
    }

	static function CanModifyPost($post, $db)
	{
		return isset($_SESSION["logged_in"]) && ($_SESSION["admin"] || $_SESSION["user"] == $post->user->username) && UserModel::ValidateUser($db);
	}

    public function LoginUser($username, $password)
    {
    	$user = $this->GetUser($username);
        if($user)
    	{
	    	if(password_verify(trim($password), trim($user->passwordhash)))
	    	{
	    		$_SESSION["logged_in"] = true;
	    		//Use this for validation.
	    		$_SESSION["login_string"] = hash("sha256", $_SERVER['HTTP_USER_AGENT'].$user->passwordhash);
				$_SESSION["userid"] = $user->id;
	    		$_SESSION["user"] = $username;
				$_SESSION["admin"] = $user->isAdmin;
				$this->ExecQuery("UPDATE USER SET last_login = :LoginDate WHERE USER.userid = :userid", array(":LoginDate" => date("Y-m-d H:i:s"), ":userid" => $user->id));
	    		                return true;
	    	}
	    	return false;
    	}

    	return false;
    }

	public function AddBio($user,$content)
	{
		$SQL = "UPDATE USER SET bio = :bio WHERE USER.userid = :user";
		$param = array(':bio'=>$content, ':user'=>$user,);
		$this->ExecQuery($SQL, $param);
	}

	public function GrantAdmin($user)
	{
		$SQL = "UPDATE USER SET admin = 1 WHERE USER.userid = :user";
		$param = array(':user'=>$user,);
		$this->ExecQuery($SQL, $param);
	}
}