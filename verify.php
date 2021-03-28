<?php



if (isset($_GET['email']) && isset($_GET['etoken'])) {
    $email = $_GET['email'];
    $emailtoken =  $_GET['etoken'];
    if ($email != '' && $emailtoken != '') {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            require_once 'db.php';

            $sql = "SELECT * FROM users WHERE email='" . $email . "'";
            $emailresult = $conn->query($sql);

            if ($emailresult->num_rows > 0) {

                $userdata = $emailresult->fetch_assoc();

                $salt = "hkjg56468sd32f1dfsdfsf1nh6gf54hxcvng4f6h54gf1";
                $tokensecret = $userdata['token_secret'];

                $validtoken = sha1($tokensecret . $salt);
                if ($emailtoken == $validtoken) {

                    $sql = "UPDATE users SET blocked='0' WHERE email='" . $email . "'";

                    $regres = $conn->query($sql);
                    if ($regres) {
                        header('Content-Type: application/json');
                        echo json_encode(array("message" => "حساب کاربری شما فعال گردید"));
                    } else {
                        header('Content-Type: application/json');
                        echo json_encode(array("message" => "مشکل در دیتابیس"));
                    }


                } else {
                    header('Content-Type: application/json');
                    http_response_code(403);
                    echo json_encode(array("message" => "توکن نامعتبر است"));
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(array("message" => "شما با این ایمیل ثبت نام نکرده اید"));
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("message" => "ایمیل نامعتبر است!"));
        }
    } else {
        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode(array("message" => "پارامتر خالی ارسال شده است!"));
    }
} else {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(array("message" => "درخواست نامعتبر است"));
}
