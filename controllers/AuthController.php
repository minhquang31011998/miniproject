<?php 
require_once('models/User.php');

class AuthController{
	var $model_obj;

	function __construct(){
		$this->model_obj = new User();
	}

	function login(){
		require_once('views/admin/login.php');
		exit();
	}

	function login_process(){
		$email =addslashes($_POST['email']);
		$password = md5(addslashes($_POST['password']));

		$user = $this->model_obj->login($email,$password);
		if($user == NULL){
			setcookie('alert','email hoặc password ko đúng',time()+5);
			header("Location: index.php?mod=auth&act=login");
			exit();
			
		}else{
			
			
			$_SESSION['isLogin'] = 'ok';
			
			$_SESSION['user'] = $user;
			unset($user['password']);
			if(isset($_POST['remember'])){
				setcookie("email",$_POST['email'],time()+1000,"/");
				setcookie("password",$_POST['password'],time()+1000,"/");
			}
			header("Location: index.php?mod=admin&act=index");
			exit();
		}

	}

	function error(){
		require_once('views/admin/404.php');
	}
}
?>