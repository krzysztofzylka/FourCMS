<?php
return new class(){ //create main class
	public $hashAlghoritm = 'pbkdf2'; //hash alghoritm
	public $sessionName = 'userID'; //user session name
	public $userData = null; //user data
	public $DBTablePrefix = ''; //prefix for table in database
	public $defaultPermissionGroup = 1; //default permission
	private $dbConn = null; //PDO Object
	public function __construct(){ //main function
		core::setError();
		if(core::$library->database->isConnect === false)// if not connect
			return core::setError(1, 'no connection to the database'); //return error 1
		$this->dbConn = core::$library->database->conn; //get db connect
	}
	public function _install() : bool { //install module to database
		core::setError();
		$sql = "CREATE TABLE ".$this->DBTablePrefix."user (
			id INT(11) AUTO_INCREMENT PRIMARY KEY,
			login VARCHAR(30) NOT NULL,
			password VARCHAR(50) NOT NULL,
			email VARCHAR(50),
			permission int(11)
		);
		CREATE TABLE `".$this->DBTablePrefix."groupPermission` (
			`id` INT(24) NOT NULL AUTO_INCREMENT, 
			`name` VARCHAR(255) NOT NULL, 
			`permission` TEXT NOT NULL, 
			PRIMARY KEY (`id`)
		)"; //sql
		try{
			$this->dbConn->exec($sql); //exec
			return true; //return success
		}catch(Exception $error){
			return core::setError(1, 'error create table', $error->getMessage()); //return error 1
		}
	}
	public function createUser(string $login, string $password, string $email) : bool { //add user to database
		core::setError();
		$password = core::$library->crypt->hash(htmlspecialchars($password), $this->hashAlghoritm); //crypt password
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) //check email
			return core::setError(1, 'Invalid email format'); //return error 1
		$exec = "INSERT INTO ".$this->DBTablePrefix."user (login, password, email, permission) VALUES ('".htmlspecialchars($login)."', '".$password."', '".htmlspecialchars($email)."', '".$this->defaultPermissionGroup."')"; //sql
		$check = $this->dbConn->query('SELECT count(*) as count FROM '.$this->DBTablePrefix.'user WHERE login="'.htmlspecialchars($login).'" LIMIT 1')->fetch(PDO::FETCH_ASSOC); //count user
		if($check['count'] > 0) //check user
			return core::setError(2, 'a user with such a login already exists'); //return error 2
		$this->dbConn->exec($exec); //exec script
		return true; //return success
	}
	public function loginUser(string $login, string $password) : bool { //login user
		core::setError();
		$login = htmlspecialchars($login); //protect login
		$password = htmlspecialchars($password); //protect password
		$user = $this->dbConn->query('SELECT count(id) as count, id, password FROM '.$this->DBTablePrefix.'user WHERE login="'.$login.'"')->fetch(PDO::FETCH_ASSOC); //get user from database
		if($user['count'] == 0) //not found
			return core::setError(1, 'user with such login was not found'); //return error 1
		$check = core::$library->crypt->hashCheck($password, $user['password']); //check password
		if($check === false) //check password
			return core::setError(2, 'password incorrect'); //return error 2
		$_SESSION[$this->sessionName] = (int)$user['id']; //set session
		return true; //return success
	}
	public function changePassword(string $login, string $password, string $newPassword){ //change password
		core::setError();
		$login = htmlspecialchars($login); //protect login
		$password = htmlspecialchars($password); //protect password
		$newPassword = htmlspecialchars($newPassword); //protect new password
		$user = $this->dbConn->query('SELECT count(id) as count, id, password FROM '.$this->DBTablePrefix.'user WHERE login="'.$login.'"')->fetch(PDO::FETCH_ASSOC); //get user from database
		if($user['count'] == 0) //not found
			return core::setError(1, 'user with such login was not found'); //return error 1
		$check = core::$library->crypt->hashCheck($password, $user['password']); //check password
		if($check === false) //check password
			return core::setError(2, 'password incorrect'); //return error 2
		$newPassword = core::$library->crypt->hash(htmlspecialchars($newPassword), $this->hashAlghoritm); //crypt password
		$this->dbConn->query('UPDATE '.$this->DBTablePrefix.'user SET password="'.$newPassword.'" WHERE id='.$user['id'])->fetch(PDO::FETCH_ASSOC); //get user from database
		return true;
	}
	public function checkUser() : bool { //check user login
		core::setError();
		if(!isset($_SESSION[$this->sessionName])) //check is isset session
			return false; //return false
		elseif(!is_int($_SESSION[$this->sessionName])) //check int
			return false; //return false
		return true; //return success
	}
	public function logoutUser() : bool{ //logout
		core::setError();
		if($this->checkUser() === false) //check user
			return core::setError(1, 'the user is not logged in'); //return error 1
		unset($_SESSION[$this->sessionName]); //delete session
		$this->userData = null; //delete userData
		return true;
	}
	public function userGetData(){ //get user data
		core::setError();
		$userID = (int)htmlspecialchars($_SESSION[$this->sessionName]); //protect user ID
		$user = $this->dbConn->query("SELECT * FROM ".$this->DBTablePrefix."user WHERE id=".$userID); //get Data
		$user = $user->fetch(PDO::FETCH_ASSOC); //fetch data
		$this->userData = $user; //add data to userData
		$this->getPermission(); //get user permission
		return $user; //return user data
	}
	public function getData(int $userID = -1){
		core::setError();
		$userID = $userID<>-1?(int)$userID:(int)htmlspecialchars($_SESSION[$this->sessionName]);
		$user = $this->dbConn->query("SELECT * FROM ".$this->DBTablePrefix."user WHERE id=".$userID);
		$user = $user->fetch(PDO::FETCH_ASSOC);
		return $user;
	}
	public function getPermission(){ //get user permission
		core::setError();
		if($this->checkUser() === false) //check user
			return core::setError(1, 'the user is not logged in'); //return error 1
		if($this->userData === null)
			$this->userGetData();
		if(isset($this->userData['userPermissionArray']) and is_array($this->userData['userPermissionArray']))
			return $this->userData['userPermissionArray'];
		$permission = $this->dbConn->query('SELECT permission FROM '.$this->DBTablePrefix.'groupPermission WHERE id='.((int)$this->userData['permission']))->fetch(PDO::FETCH_ASSOC); //ger permission from database
		return json_decode($permission['permission']);
	}
	public function checkPermission(string $name) : bool{ //check permission
		core::setError();
		if($this->checkUser() === false) //check user
			return core::setError(1, 'the user is not logged in'); //return error 1
		if($this->userData === null)
			$this->userGetData();
		$permission = $this->getPermission();
		if(!is_bool(array_search('all_granted', $permission)))
			return true;
		return !is_bool(array_search($name, $permission));
	}
	public function setTablePrefix(string $prefix) : bool{ //set table prefix
		core::setError();
		$this->DBTablePrefix = $prefix.'_';
		return true;
	}
	public function userList(){
		core::setError();
		return core::$library->database->query('SELECT * FROM '.$this->DBTablePrefix.'user')->fetchAll();
	}
	public function getUserID(string $login){
		core::setError();
		$getData = core::$library->database->prepare('SELECT id FROM '.$this->DBTablePrefix.'user WHERE login=:login');
		$getData->bindParam(':login', $login, PDO::PARAM_STR);
		$getData->execute();
		return $getData->fetch(PDO::FETCH_ASSOC)['id'];
	}
	public function getPermissionName(int $permissionID){
		core::setError();
		$permission = core::$library->database->prepare('SELECT * FROM '.$this->DBTablePrefix.'groupPermission WHERE id=:id');
		$permission->bindParam(':id', $permissionID, PDO::PARAM_INT);
		$permission->execute();
		return $permission->fetch(PDO::FETCH_ASSOC)['name'];
	}
	public function getPermissionList(){
		core::setError();
		$permission = core::$library->database->prepare('SELECT * FROM '.$this->DBTablePrefix.'groupPermission');
		$permission->execute();
		return $permission->fetchAll(PDO::FETCH_ASSOC);
	}
	public function setUserPermission(int $userID, int $permissionGroupID) : bool{
		core::setError();
		$permission = core::$library->database->prepare('UPDATE '.$this->DBTablePrefix.'user SET permission=:permission WHERE id=:id');
		$permission->bindParam(':permission', $permissionGroupID, PDO::PARAM_INT);
		$permission->bindParam(':id', $userID, PDO::PARAM_INT);
		$permission->execute();
		return true;
	}
	public function getUserList(){
		core::setError();
		$getData = core::$library->database->prepare('SELECT * FROM '.$this->DBTablePrefix.'user');
		$getData->execute();
		return $getData->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>