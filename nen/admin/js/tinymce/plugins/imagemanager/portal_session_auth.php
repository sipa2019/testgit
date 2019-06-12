<?php
session_start();

//var_dump($_SESSION['ShopTinyNamespace']);exit;


$dir = '../user_image';
$userId = 'admin';



if($dir && $userId) {
	//$custom_image_dir = '/userdata/users/'; $dir = $_SERVER['DOCUMENT_ROOT'] .$custom_image_dir.$_SESSION['HPportal']['currentUserId'];
	if (!file_exists($dir)){
        $dir_created = mkdir($dir);
	} else {
		$dir_created = true;
	}

	if(!$dir_created) {
		echo '<div>Can not create dir '. $dir .'</div>';
		return;
	}

	$_SESSION['MyIsLoggedInState'] = true;
    $_SESSION['isLoggedIn'] = true;
    $_SESSION['user'] = $userId;
    $_SESSION['imagemanager.filesystem.path'] = $dir;
    $_SESSION['imagemanager.filesystem.rootpath'] = $dir;
    
    if(isset($_REQUEST['return_url'])){
    	$url = urldecode($_REQUEST['return_url']);
    } else {
    	$url = "/js/tinymce/plugins/imagemanager/js/../index.php?type=im&page=index.html";
    }

    header("Location: http://".$_SERVER['HTTP_HOST'].$url);//test
    exit;

} else {

    unset($_SESSION['MyIsLoggedInState']);
    unset($_SESSION['isLoggedIn']);
    unset($_SESSION['user']);
    unset($_SESSION['imagemanager.filesystem.path']);
    unset($_SESSION['imagemanager.filesystem.rootpath']);

    echo '<div>User is not logged in</div>';//TODO
}