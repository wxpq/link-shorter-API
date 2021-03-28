<?php



function create_short_code(){
    $sets = explode('|', "abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789");
    $all = '';
    $randString = '';
    foreach($sets as $set){
        $randString .= $set[array_rand(str_split($set))];
        $all .= $set;
    }
    $all = str_split($all);
    for($i = 0; $i < 6 - count($sets); $i++){
        $randString .= $all[array_rand($all)];
    }
    $randString = str_shuffle($randString);
    return $randString;
}



if ($_SERVER["REQUEST_METHOD"] == "GET") {
    header('Content-Type: application/json');
    die(json_encode(array("message" => "متد نامعتبر"),JSON_UNESCAPED_SLASHES));
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $postdata = (array)json_decode(file_get_contents("php://input"));
    if (isset($postdata["username"]) && isset($postdata["token"]) && isset($postdata["link"])) {
        if ($postdata["username"] != '' && $postdata["token"] != '' && $postdata["link"] != '') {



            if (preg_match("/(\w+){4,12}/", $postdata["username"])) {
                require_once 'db.php';
                $sql = "SELECT token_secret,blocked FROM users WHERE username='" . $postdata["username"] . "'";
                $usrresult = $conn->query($sql);

                if ($usrresult->num_rows > 0) {

                    $salt = "hkjg56468sd32f1xzvg4f65asdadadshxcvng4f6h54gf1";
                    $userdata = $usrresult->fetch_assoc();

                    if (sha1($postdata["token"] . $postdata["username"] . $salt) == $userdata["token_secret"]) {
                        if ($userdata["blocked"] == '0') {

                            if (preg_match('/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}' . '((:[0-9]{1,5})?\\/.*)?$/i', $postdata["link"])) {

                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $postdata["link"]);
                                curl_setopt($ch, CURLOPT_NOBODY, true);
                                curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
                                curl_exec($ch);
                                $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                curl_close($ch);
                                if (!empty($response) && $response != 404) {
                                    $is_uniq_shortcode = false;
                                    while(!$is_uniq_shortcode){
                                        $shortcode = create_short_code();
                                        $sql = "SELECT * FROM links WHERE short_code='".$shortcode."'";
                                        $shortcode_uniq_result = $conn->query($sql);
                                        if($shortcode_uniq_result->num_rows > 0){
                                            $is_uniq_shortcode = false;
                                        }else{
                                            $is_uniq_shortcode = true;
                                        }
                                    }

                                    $sql = "INSERT INTO links (main_url, short_code, owner) VALUES ('" . $postdata["link"] . "', '" . $GLOBALS['shortcode'] . "', '" . $postdata["username"]. "');";
                                    $linkres = $conn->query($sql);
                                    if ($linkres) {


                                    header('Content-Type: application/json');
                                    die(json_encode(array("message" => "لینک شما با موفقیت کوتاه شد","shortlink" => "https://wwwwww.ir/s/".$GLOBALS['shortcode']),JSON_UNESCAPED_SLASHES));


                                    }else{
                                        header('Content-Type: application/json');
                                        die(json_encode(array("message" => "مشکلی در ذخیره سازی لینک در دیتابیس بوجود آمده است"),JSON_UNESCAPED_SLASHES));
                                    }

                                } else {
                                    header('Content-Type: application/json');
                                    die(json_encode(array("message" => "لینک شما وجود ندارد یا نامعتبر است"),JSON_UNESCAPED_SLASHES));
                                }
                            } else {
                                header('Content-Type: application/json');
                                die(json_encode(array("message" => "ساختار لینک شما درست نیست"),JSON_UNESCAPED_SLASHES));
                            }
                        } else {
                            header('Content-Type: application/json');
                            die(json_encode(array("message" => "شما ایمیل خود را تایید نکرده اید"),JSON_UNESCAPED_SLASHES));
                        }
                    } else {
                        header('Content-Type: application/json');
                        die(json_encode(array("message" => "توکن شما نامعتبر است!"),JSON_UNESCAPED_SLASHES));
                    }
                } else {
                    header('Content-Type: application/json');
                    die(json_encode(array("message" => "شما ثبت نام نکرده اید!"),JSON_UNESCAPED_SLASHES));
                }
            } else {
                header('Content-Type: application/json');
                die(json_encode(array("message" => "نام کاربری نامعتبر"),JSON_UNESCAPED_SLASHES));
            }
        } else {
            header('Content-Type: application/json');
            die(json_encode(array("message" => "پارامتر خالی ارسال شده است"),JSON_UNESCAPED_SLASHES));
        }
    } else {
        header('Content-Type: application/json');
        die(json_encode(array("message" => "پارامتر های لازم ست نشده اند!"),JSON_UNESCAPED_SLASHES));
    }
}
