<?php/*Student Media Reservation SystemAuthor: Andrew MeltonFilename: /lib/db_user_functions.phpPurpose: 	This file contains all functions related to users  in the database	Known Bugs/Fixes:	None	*//*	Simply gets the proper information to process a login.*/function processLogin($userid){	$userid = makeStringSafe($userid);	return doQuery("SELECT user_id,password,user_level FROM ".getDBPrefix()."_users WHERE student_id = '".$userid."'");}/*	Creates a new user and gives them a random password. It then returns that password.*/function newUserNoPassword($stuid, $name, $email, $user_level){	$stuid = makeStringSafe($stuid);	$name = makeStringSafe($name);	$email = makeStringSafe($email);	$user_level = makeStringSafe($user_level);	$password = makeStringSafe(generatePassword(9,4));	doQuery("INSERT INTO ".getDBPrefix()."_users SET student_id = '".$stuid."', name = '".$name."', password = '".makeStringSafe(encrypt($password))."', email = '".$email."', user_level = '".$user_level."', warnings = '0'");		$user = mysql_fetch_assoc(doQuery("SELECT user_id FROM ".getDBPrefix()."_users ORDER BY user_id DESC LIMIT 1"));		logAddUser($_SESSION['user_id'], $user['user_id']);		return $password;	}/*	Creates a new user with a provided password.*/function newUser($stuid, $name, $password, $email){	$stuid = makeStringSafe($stuid);	$name = makeStringSafe($name);	$password = makeStringSafe($password);	$email = makeStringSafe($email);	doQuery("INSERT INTO ".getDBPrefix()."_users SET student_id = '".$stuid."', name = '".$name."', password = '".makeStringSafe(encrypt($password))."', email = '".$email."', user_level = '".RES_USERLEVEL_USER."', warnings = '0'");		$user = mysql_fetch_assoc(doQuery("SELECT user_id FROM ".getDBPrefix()."_users ORDER BY user_id DESC LIMIT 1"));		logAddUser($_SESSION['user_id'], $user['user_id']);}function changeUserPassword($userid, $newpass){	$userid = makeStringSafe($userid);	$newpass = makeStringSafe($newpass);	doQuery("UPDATE ".getDBPrefix()."_users SET password = '".makeStringSafe(encrypt($newpass))."'  WHERE user_id = ".$userid."");	logChangeUserPassword($userid);	}function changeUserEmail($userid, $email){	$userid = makeStringSafe($userid);	$email = makeStringSafe($email);	doQuery("UPDATE ".getDBPrefix()."_users SET email = '".$email."'  WHERE user_id = ".$userid."");	logChangeUserEmail($userid);	}function changeUserNotes($userid, $notes){	$userid = makeStringSafe($userid);	$notes = makeStringSafe($notes);	doQuery("UPDATE ".getDBPrefix()."_users SET notes= '".$notes."'  WHERE user_id = ".$userid."");	logChangeUserNotes($userid);	}function getUserByID($userid){	$userid = makeStringSafe($userid);	return doQuery("SELECT * FROM ".getDBPrefix()."_users WHERE user_id = '".$userid."'");}function getAllUsers(){	return doQuery("SELECT * FROM ".getDBPrefix()."_users");}function getAllUsersOrderByName(){	return doQuery("SELECT * FROM ".getDBPrefix()."_users ORDER BY name ASC");}function getAllUsersByUserLevel($level){	$level = makeStringSafe($level);	return doQuery("SELECT * FROM ".getDBPrefix()."_users WHERE user_level = '".$level."'");}function getAdmins(){	return getAllUsersByUserLevel(getConfigVar("admin_rank"));}?>