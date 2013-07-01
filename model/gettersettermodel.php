<?php
session_start ();
require_once 'model.php';
ini_set ( "display_error", 'on' );
class Register extends model {
	protected $user;
	protected $avatar;
	protected $turn;
	protected $method;
	
	/**
	 * @return the $random1
	 */
	


	public function getMethod() {
		return $this->method;
	}

	/**
	 * @param field_type $random1
	 */
	public function setMethod($method) {
		$this->method = $method;
	}

	/**
	 *
	 * @return the $username
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 *
	 * @return the $password
	 */
	public function getAvatar() {
		return $this->avatar;
	}
	
	/**
	 *
	 * @param field_type $username        	
	 */
	public function setUser($user) {
		$this->user = $user;
	}
	
	/**
	 *
	 * @param field_type $password        	
	 */
	public function setTurn($turn) {
		$this->turn = $turn;
	}
	public function setAvatar($avatar) {
		$this->avatar = $avatar;
	}
	public function getTurn() {
		return $this->turn;
	}
	
	
	
	
	
	
	public function insertUser() {
		$this->db->Fields ( array ("name" =>  $this->getUser () ,"turn" => $this->getTurn ()  ,"avatar" => $this->getAvatar () , "playing" => "N" , "chance" => "N" , "position" => "-1" , "method" => $this->getMethod ()));
		$this->db->From ( "user" );
		$result = $this->db->Insert ();
		return $result;
	}

	public function fetchUser() {
		$this->db->Fields (array("playing"));
		$this->db->From ( "user");
		$this->db->Where (array("name" => $this->getUser ()));
		$this->db->Select ();
		$result = $this->db->resultArray();
		$_SESSION['user'] = $this->getUser ();
		
		if($result[0]['playing'] != "0")
		{
			$_SESSION['play'] = $result[0]['playing'] ;
			$this->db->Fields (array("avatar" , "name"));
			$this->db->From ("user where playing =  ". $result[0]['playing'] ." and name != '".$this->getUser () . "'");
			$this->db->Select ();
			$result = $this->db->resultArray();
			return $result;
		}
		else
		{
			$this->db->Fields (array("avatar" , "name"));
			$this->db->From ( "user where name != '".$this->getUser (). "' and turn = '".$this->getTurn ()."' and  avatar != '".$this->getAvatar () ."' and playing = '0' and chance = 'N' and method = '". $this->getMethod () . "'");
			$this->db->Select ();
			$result = $this->db->resultArray();
			return $result;
		}
	}
	public function updateUser($users) 
	{
		$this->db->Fields (array("playing"));
		$this->db->From ( "user");
		$this->db->Where (array("name" => $_SESSION['user']));
		$this->db->Select ();
		$result = $this->db->resultArray();
		if($result[0]['playing'] == "0")
		{
			$arr = rand(1, 500);
			$_SESSION['play'] = $arr;
			for($i =0 ; $i < count($users) ; $i ++)
			{
				$this->db->Fields (array("Playing"=>$arr));
				$this->db->From ( "user" );
				$this->db->Where (array("name" => $users[$i]));
				$this->db->Update ();
			}
			if($i == count($users))
			return "1";
		}
		else
			return "-1";
		
	}

	public function updateUserPosition($users , $user , $pos) 
	{

		$this->db->Fields (array("chance"=>"N" , "position" => $pos));
		$this->db->From ( "user" );
		$this->db->Where (array("name" => $user));
		$result = $this->db->Update ();
		if ($result)
		{
			$a = 0;
			
			sort($users);
			for($i =0 ; $i < count($users) ; $i ++)
			{
				if(($users[$i] == $user) && ($i != (count($users) - 1)))
				{
					$a = 1;
				}
				if($users[$i] != $user && ($a == 1))
				{
					$this->db->Fields (array("chance" => "Y"));
					$this->db->From ( "user" );
					$this->db->Where (array("name" => $users[$i]));
					$result1 = $this->db->Update ();
					break;
				}
				if(($i == (count($users) - 1)) && ($a == 0))
				{
					$this->db->Fields (array("chance" => "Y"));
					$this->db->From ( "user" );
					$this->db->Where (array("name" => $users[0]));
					$result1 = $this->db->Update ();
					break;
				}
			}
			
		}
		if($result && $result1)
		{
			return $result1 ;
		}
		
	}

	public function getChance() 
	{
		

		$this->db->Fields (array("name"));
		$this->db->From ( "user" );
		$this->db->Where (array("chance" => 'Y' , "playing" => $_SESSION['play']));
		$this ->db->Limit("1");
		$this->db->Select ();
		$result1 = $this->db->resultArray();
		return $result1;
		
	}

	public function getPosition() 
	{
		$this->db->Fields (array("playing"));
		$this->db->From ( "user" );
		$this->db->Where (array("name" => $_SESSION['user']));
		$this->db->Select ();
		$result = $this->db->resultArray();
		$this->db->Fields (array("position" , "name" , "avatar"));
		$this->db->From ( "user where name != '" . $this->getUser () ."'  and playing = '" . $result[0]['playing'] . "'");
		$this->db->Select ();
		$result1 = $this->db->resultArray();
		return $result1;
		
	}

	public function deleteUser() 
	{
		$this->db->From ( "user");
		$this->db->Where (array("name" => $this->getUser()));
		$this->db->Delete ();		
		echo $this->db->lastQuery(); 
	}

	public function setChance($users) 
	{
		sort($users);
		for($i =0 ; $i < count($users) ; $i ++)
		{
			$this->db->Fields (array("chance" , "name"));
			$this->db->From ( "user" );
			$this->db->Where (array("name" => $users[$i]));
			$result = $this->db->Select ();
			$result = $this->db->resultArray();
			if($result[0]['chance'] == "Y")
			{
				break;
			}
		}
		if($i == count($users))
		{
			$this->db->Fields (array("chance" => "Y"));
			$this->db->From ( "user" );
			$this->db->Where (array("name" => $users[0]));
			$this->db->Update ();
		}		
	}

	


	public function logOut() {
		$this->db->Fields ( array (
				"loggedin" => "N" , "playing"=>"N"
		) );
		$this->db->From ( "user" );
		$this->db->Where ( array (
				"username" => $_SESSION ['username'] 
		) );
		$result = $this->db->Update ();
		if ($result == "1") {
			session_destroy ();
			return $result;
		}
	}
	public function loggedinCount() {
		$this->db->Fields ( array (
				"username",
				"id" 
		) );
		$this->db->From ( "user where loggedin='Y' and playing <> 'Y'");
		$this ->db->Limit("4");
		$this->db->Select ();
		
		$result = $this->db->resultArray ();
		
		
		
		return (count($result));
	}

	public function getnewMessage() {
		$this->db->Fields ( array ("message","user") );
		$this->db->From ($_SESSION ['user1'][0].$_SESSION ['user2'][0].$_SESSION ['user3'][0].$_SESSION ['user4'][0]."message");
		$this->db->Where ( array ("status" => "n" ));
		$this->db->Select ();
		//$this ->db->Limit("4");
		$result = $this->db->resultArray ();
		return ($result);
	}
	
	public function fetchPlayingUser() {
		$this->db->Fields ( array ("username") );
		$this->db->From ("user");
		$this->db->Where ( array ("loggedin" => "Y" , "playing" => "Y" ));
		$this->db->Select ();
		$this ->db->Limit("4");
		$result = $this->db->resultArray ();
		for($i =0 ; $i < count($result) ; $i ++)
		{
			$_SESSION["user".$this->j] = $result[$i]['username'];
				$this->j ++;
		}
		return ($result);
	}
	
}


?>
