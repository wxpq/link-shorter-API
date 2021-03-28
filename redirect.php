<?php
error_reporting(E_ERROR | E_PARSE);
if(isset($_GET['c'])){
    if($_GET['c'] != ''){
        $shortcode = $_GET['c'];
        if(preg_match("/^[A-Za-z0-9]{6}$/",$shortcode)){
            require_once 'db.php';
            $sql = "SELECT main_url FROM links WHERE short_code='" . $shortcode . "'";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $linkdata = $result->fetch_assoc();
                if(preg_match("/http:\/\/wawwwwasdaaas.com/",$linkdata['main_url'])){ //for redirect on custom urls
                //    echo file_get_contents($linkdata['main_url']);
                    echo "فعلا این فیچر غیر فعاله!";
                }else{
                    header('Location: '.$linkdata['main_url']);
                }
                
            }else{
                header('Content-Type: application/json');
                echo json_encode(array("message" => "لینکی با این کد کوتاه وجود ندارد!"));
            }
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("message" => "ساختار نادرست در کد کوتاه"));
        }

    }
}

