<?php
session_start();

require_once 'PHPMailer/class.phpmailer.php';
$mail = new PHPMailer;

// SMTP configuration
$mail->isSMTP();
$mail->Host = 'mail.wwwwwwww.ir';
$mail->SMTPAuth = true;
$mail->Username = 'info@wwwwwwww.ir';
$mail->Password = 'dasdadadaasd';
// $mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('info@wwwwwwww.ir', 'wwwwwwwwwwww.ir');
$mail->CharSet = 'UTF-8';




if ($_SERVER["REQUEST_METHOD"] == "GET") {
    header('Location: index.php');
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $postdata = (array)json_decode(file_get_contents("php://input"));


    if (isset($postdata["username"]) && isset($postdata["email"]) && isset($postdata["pass1"]) && isset($postdata["pass2"]) && isset($postdata["anticsrf"]) && isset($postdata["g-recaptcha-response"]) && isset($postdata["mode"])) {
        $email = $postdata["email"];
        $pass1 = $postdata["pass1"];
        $pass2 = $postdata["pass2"];
        $anticsrf = $postdata["anticsrf"];
        $recaptchares = $postdata["g-recaptcha-response"];

        if ($postdata["username"] != '' && $email != '' && $pass1 != '' && $pass2 != '' && $anticsrf == $_SESSION['csrf_token'] && $recaptchares != '' && $postdata["mode"] == 'register') {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) != false) {
                if ($pass1 == $pass2) {

                    if (strlen($pass1) <= '8') {
                        header('Content-Type: application/json');
                        die(json_encode(array("message" => "پسورد حداقل باید 9 کاراکتر باشد")));
                    } elseif (!preg_match("#[0-9]+#", $pass1)) {
                        header('Content-Type: application/json');
                        die(json_encode(array("message" => "پسورد حداقل باید دارای یک رقم عددی باشد")));
                    } elseif (!preg_match("#[A-Z]+#", $pass1)) {
                        header('Content-Type: application/json');
                        die(json_encode(array("message" => "پسورد حداقل باید دارای یک حرف بزرگ لاتین باشد")));
                    } elseif (!preg_match("#[a-z]+#", $pass1)) {
                        header('Content-Type: application/json');
                        die(json_encode(array("message" => "پسورد باید حداقل دارای یک کوچک لاتین باشد")));
                    }

                    $secretKey = "6LeIasdaddasAAAGKasdasdadasd6M0olUwN";
                    $googleurl = 'https://www.google.com/recaptcha/api/siteverify';
                    $data = array('secret' => $secretKey, 'response' => $recaptchares);
                    $options = array(
                        'http' => array(
                            'header'  => "Content-type: application/x-www-form-urlencoded",
                            'method'  => 'POST',
                            'content' => http_build_query($data)
                        )
                    );
                    $context  = stream_context_create($options);
                    $response = file_get_contents($googleurl, false, $context);
                    $responseKeys = json_decode($response, true);
                    if ($responseKeys["success"]) {
                        require_once 'db.php';
                        $username = $postdata["username"];
                        if (strlen($username) >= 12) {
                            header('Content-Type: application/json');
                            echo json_encode(array("message" => "برای نام کاربری حداکثر از 12 کاراکتر میتوانید استفاده کنید"));
                        } else {

                            if (preg_match("/(\w+){4,12}/", $username)) {

                                $sql = "SELECT * FROM users WHERE username='" . $username . "'";
                                $usrresult = $conn->query($sql);

                                $sql = "SELECT * FROM users WHERE email='" . $email . "'";
                                $emailresult = $conn->query($sql);

                                if ($usrresult->num_rows > 0 || $emailresult->num_rows > 0) {
                                    header('Content-Type: application/json');
                                    echo json_encode(array("message" => "شما قبلا ثبت نام کرده اید"));
                                } else {
                                    $token = sha1(time() . uniqid() . md5(microtime()));
                                    $salt = "hkjg56468sd32f1xzvg4f6asdsadadv1nh6gf54hxcvng4f6h54gf1";
                                    $tokensecret = sha1($token . $username.$salt);


                                    $sql = "INSERT INTO users (username, password, email,token_secret, blocked) VALUES ('" . $username . "', SHA1('" . $pass1 . "'), '" . $email . "','" . $tokensecret . "', '1');";
                                    $regres = $conn->query($sql);
                                    if ($regres) {

                                        // Add a recipient
                                        $mail->addAddress($email);

                                        // Email subject
                                        $mail->Subject = 'ایمیل تایید shorter API سایت wwwwwwwwwwwwww.ir';

                                        // Set email format to HTML
                                        $mail->isHTML(true);

                                        // Email body content
                                        $mailContent = "<h1>از طریق لینک زیر میتوانید حساب API کوتاه کننده خود را فعال نمایید</h1>
                                        <a href='https://wwwwwwwwww.ir/s/verify.php?email=" . $email . "&etoken=" . sha1($tokensecret . $salt) . "'>فعالسازی حساب</a>";
                                        $mail->Body = $mailContent;

                                        // Send email
                                        if (!$mail->send()) {
                                            echo 'Message could not be sent.';
                                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                                        } else {
                                            header('Content-Type: application/json');
                                            echo json_encode(array("message" => "شما با موفقیت ثبت نام شدید،جهت استفاده از توکن ایمیل خود را تایید کنید", "token" => $token));
                                        }
                                    } else {
                                        header('Content-Type: application/json');
                                        echo json_encode(array("message" => "مشکل در دیتابیس"));
                                    }
                                }
                            } else {
                                header('Content-Type: application/json');
                                echo json_encode(array("message" => "نام کاربری شما باید حداقل ۴ کاراکتر و حداکثر ۱۲ کاراکتر باشد و برای نام کاربری از کاراکتر های #,@,$,%,^,&,*,+,...نمی توانید استفاده کنید"));
                            }
                        }
                    } else {
                        header('Content-Type: application/json');
                        echo json_encode(array("message" => "ارور در کپچا گوگل"));
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(array("message" => "پسورد ها برابر نیستند"));
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(array("message" => "ایمیل نامعتبر است"));
            }
        } else {
            header('Content-Type: application/json');
            http_response_code(403);
            echo json_encode(array("message" => "پیلود ناقص است"));
        }
    } elseif (isset($postdata["email"]) && isset($postdata["pass1"]) && isset($postdata["anticsrf"]) && isset($postdata["g-recaptcha-response"]) && isset($postdata["mode"])) {
        if ($postdata["email"] != '' && $postdata["pass1"] != '' && $postdata["anticsrf"] == $_SESSION['csrf_token'] && $postdata["g-recaptcha-response"] != '' && $postdata["mode"] == 'gettoken') {


            if (filter_var($postdata["email"], FILTER_VALIDATE_EMAIL) != false) {

                if (strlen($postdata["pass1"]) <= '8') {
                    header('Content-Type: application/json');
                    die(json_encode(array("message" => "ورودی نامعتبر")));
                } elseif (!preg_match("#[0-9]+#", $postdata["pass1"])) {
                    header('Content-Type: application/json');
                    die(json_encode(array("message" => "ورودی نا معتبر")));
                } elseif (!preg_match("#[A-Z]+#", $postdata["pass1"])) {
                    header('Content-Type: application/json');
                    die(json_encode(array("message" => "ورودی نامعتبر")));
                } elseif (!preg_match("#[a-z]+#", $postdata["pass1"])) {
                    header('Content-Type: application/json');
                    die(json_encode(array("message" => "ورودی نا معتبر")));
                }

                $secretKey = "6LeIr8AZAAAAAGKBQ1LT62BhJJ4F3tC46M0olUwN";
                $googleurl = 'https://www.google.com/recaptcha/api/siteverify';
                $data = array('secret' => $secretKey, 'response' => $postdata["g-recaptcha-response"]);
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded",
                        'method'  => 'POST',
                        'content' => http_build_query($data)
                    )
                );
                $context  = stream_context_create($options);
                $response = file_get_contents($googleurl, false, $context);
                $responseKeys = json_decode($response, true);
                if ($responseKeys["success"]) {
                    require_once 'db.php';
                    $salt = "hkjg56468sd32f1xzvg4f65hf3nxcv1nh6gf54hxcvng4f6h54gf1";
					
                    $sql = "SELECT password,blocked,token_secret,username FROM users WHERE email='" . $postdata["email"] . "'";
                    $emailresult = $conn->query($sql);

                    if ($emailresult->num_rows > 0) {

                        $userdata = $emailresult->fetch_assoc();
                        if ($userdata["password"] == sha1($postdata["pass1"])) {
                        	$username = $userdata["username"];
                        	
                            if ($userdata["blocked"] == '1') {

                                // Add a recipient
                                $mail->addAddress($postdata["email"]);

                                // Email subject
                                $mail->Subject = 'ایمیل تایید shorter API سایت wwwwwww.ir';

                                // Set email format to HTML
                                $mail->isHTML(true);

                                // Email body content
                                $mailContent = "<h1>از طریق لینک زیر میتوانید حساب API کوتاه کننده خود را فعال نمایید</h1>
                                <a href='https://wwwwww.ir/s/verify.php?email=" . $postdata["email"] . "&etoken=" . sha1($userdata["token_secret"] . $salt) . "'>فعالسازی حساب</a>";
                                $mail->Body = $mailContent;

                                // Send email
                                if (!$mail->send()) {
                                    echo 'Message could not be sent.';
                                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                                } else {
                                    header('Content-Type: application/json');
                                    die(json_encode(array("message" => "ایمیل تایید برای شما ارسال شد لطفا آن را تایید کنید سپس از این قسمت توکن خود را دیافت کنید")));
                                }
                                
                            }else{
                            
                            $token = sha1(time() . uniqid() . md5(microtime()));
                            $tokensecret = sha1($token . $username . $salt);

                            $sql = "UPDATE users SET token_secret='" . $tokensecret . "' WHERE email='" . $postdata["email"] . "'";
                            $regres = $conn->query($sql);
                            if ($regres) {
                                header('Content-Type: application/json');
                                echo json_encode(array("message" =>"توکن شما با موفقیت آپدیت شد" , "token" => $token));
                            } else {
                                header('Content-Type: application/json');
                                echo json_encode(array("message" => "مشکل در دیتابیس"));
                            }
                            }
                        } else {


                            header('Content-Type: application/json');
                            echo json_encode(array("message" => "پسورد شما نادرست است"));
                        }
                    } else {

                        header('Content-Type: application/json');
                        echo json_encode(array("message" => "حساب شما یافت نشد لطفا ثبت نام کنید"));
                    }
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(array("message" => "ارور در کپچا گوگل"));
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("message" => "ایمیل نامعتبر است"));
        }
    } else {
        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode(array("message" => "پیلود ناقص است"));
    }
}
