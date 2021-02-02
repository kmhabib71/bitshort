<?php

  
include '../load.php';
include '../../connect/login.php';

if(isset($_POST['full_name_up'])){
   
$full_name = $_POST['full_name_up'];
    $upEmailMobile = $_POST['email_mobile_up'];
    $password = $_POST['password_up'];
    // $upgen = $_POST['gender_up'];

    // $birth = $_POST['birth_day'];
    // $myStr = rand();
    // $varification_code = substr($myStr, 0, 5);
    if(empty($full_name)  or empty($upEmailMobile) or empty($password)){
        echo 'All feilds are required';
    }else{
$full_name = $loadFromUser->checkInput($full_name);
$email_mobile = $loadFromUser->checkInput($upEmailMobile);
//if(strlen($password) < 5){
//    echo 'Pass < 5'; }
//$password = $loadFromUser->checkInput($upPassword);
//$screenName = ''.$first_name.'_'.$last_name.'';
//        if(DB::query('SELECT screenName FROM users WHERE screenName = :screenName', array(':screenName' => $screenName ))){
//$screenRand = rand();
//            $userLink = ''.$screenName.''.$screenRand.'';
//        }else{
//            $userLink = $screenName;
//        }
if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$email_mobile)){
  
       echo 'Email is not correct. Please try again.';
   
}else{
  if(!filter_var($email_mobile)){
      echo "Invalid Email Format";
  }else if(strlen($full_name) > 50 || strlen($full_name) < 2){
      echo "Name must be between 2-20 character";
  }else if(strlen($password) < 5 || strlen($password) >= 60){
      echo "The password is either too shor or too long";
  }else{
      if((filter_var($email_mobile,FILTER_VALIDATE_EMAIL)) && $loadFromUser->checkEmail($email_mobile) === true){
          echo "Email is already in use";
      }else{
         
        //   $loadFromUser->create('users', array('full_name'=>$full_name,'email' => $email_mobile));
         $user_id = $loadFromUser->create('users', array('full_name'=>$full_name,'email' => $email_mobile, 'password'=>password_hash($password, PASSWORD_BCRYPT), 'joind_at' => date('Y-m-d H:i:s') ));
         
          $loadFromUser->create('profile', array('userId'=>$user_id, 'birthday'=>$birth, 'full_name'=>$full_name, 'profilePic'=>'assets/img/me.jpg','coverPic'=>'assets/img/background.png',  ));


$tstrong = true;
$token = bin2hex(openssl_random_pseudo_bytes(64, $tstrong));
          $loadFromUser->create('token', array('token'=>sha1($token), 'user_id'=>$user_id));

      setcookie('FBID', $token, time()+60*60*24*7,'/',NULL, NULL, true);
            //set cookie valid for 3 days and goto index page for config
    setcookie('FBID', $token, time()+60*60*24*3,'/',NULL, NULL, true);
    
//         $to = "".$email_mobile."";

// $subject = "Paapil verification Code";

// $message = '<!DOCTYPE html><html lang="en"><head> <meta charset="UTF-8"> <title> </title> <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></head><body> <div class="container"> <div class="wrap card"> <div class="row"> <div class="col"> <h2 class="text-primary">Confirm your email address</h2> <p> There’s one quick step you need to complete before creating your paapil account. Let’s make sure this is the right email address for you — please confirm this is the right address to use for your new account. Please enter this verification code to get started on Paapil: </p> <h1><span style="border: 1px solid black;padding:5px;border-radius:2px;">'.$varification_code.'</span></h1> <p>Thanks,</p> <p>Paapil</p> </div> </div> </div> </div></body></html>';

// $headers = "MIME-Version: 1.0" . "\r\n";
// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// // More headers
// $headers .= 'From: <welcome@paapil.com>' . "\r\n";
// // $headers .= 'Cc: myboss@example.com' . "\r\n";

// mail($to,$subject,$message,$headers);




        //   header('Location: ../../verify.php?ses_id='.$user_id.'');

      }
  }
}



    }
}


if(isset($_POST['mob_email_username_in'])){
    $email_mobile = $_POST['mob_email_username_in'];
    $in_pass = $_POST['password_in'];

if(empty($email_mobile)  or empty($in_pass)){
        echo 'All feilds are required';
    }else{
    if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email_mobile)){

        if(!preg_match("^[0-9]{11}^", $email_mobile)){
            echo 'Email or Phone is not correct. Please try again';
        }else{

        if(DB::query("SELECT mobile FROM users WHERE mobile = :mobile", array(':mobile'=>$email_mobile))){
            if(password_verify($in_pass, DB::query('SELECT password FROM users WHERE mobile=:mobile', array(':mobile'=>$email_mobile))[0]['password'])){

                $user_id=DB::query('SELECT user_id FROM users WHERE mobile=:mobile', array(':mobile'=>$email_mobile))[0]['user_id'];
               $tstrong = true;
$token = bin2hex(openssl_random_pseudo_bytes(64, $tstrong));
          $loadFromUser->create('token', array('token'=>sha1($token), 'user_id'=>$user_id));

//          setcookie('FBID', $token, time()+60*60*24*7, '/', NULL, NULL, true);
                setcookie('FBID', $token, time()+60*60*24*7,'/',NULL, NULL, true);
            //set cookie valid for 3 days and goto index page for config
            setcookie('FBID', $token, time()+60*60*24*3,'/',NULL, NULL, true);

        //   header('Location: index.php');
            }else{
                echo "Password is not correct";
            }

        }else{
            echo "User hasn't found.";
        }

        }
    }else{

        if(DB::query("SELECT email FROM users WHERE email = :email", array(':email'=>$email_mobile))){

            if(password_verify($in_pass, DB::query('SELECT password FROM users WHERE email=:email', array(':email'=>$email_mobile))[0]['password'])){

                $user_id=DB::query('SELECT user_id FROM users WHERE email=:email', array(':email'=>$email_mobile))[0]['user_id'];
               $tstrong = true;
$token = bin2hex(openssl_random_pseudo_bytes(64, $tstrong));
          $loadFromUser->create('token', array('token'=>sha1($token), 'user_id'=>$user_id));

//          setcookie('FBID', $token, time()+60*60*24*7, '/', NULL, NULL, true);
                   //set cookie valid for 7 days
            setcookie('FBID', $token, time()+60*60*24*7,'/',NULL, NULL, true);
            //set cookie valid for 3 days and goto index page for config
            setcookie('FBID', $token, time()+60*60*24*3,'/',NULL, NULL, true);

        //   header('Location: index.php');
            }else{
                echo "Password is not correct";
            }

        }else{
            echo "User hasn't found.";
            }
        }
    }
}

?>
