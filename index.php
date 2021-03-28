<?php session_start();
$_SESSION['csrf_token'] = sha1("hjfh54646gfd4g9ggsdgdfg6fsdfsfsdfg4b123vcb" . time());

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/prism.css">
    <link rel="stylesheet" href="assets/styles/style.css">
    <meta name="keywords" content=" کوتاه کننده لینک, کوتاه کننده لینک گوگل, کوتاه کننده لینک تلگرام, بهترین کوتاه کننده لینک, کوتاه کننده لینک خارجی, کوتاه کننده ی لینک گوگل, کوتاه کننده ی لینک, اسکریپت کوتاه کننده لینک, ربات کوتاه کننده لینک تلگرام, کوتاه کردن لینک, ربات تلگرام کوتاه کننده لینک, سایت کوتاه کننده لینک, افزونه وردپرس کوتاه کننده لینک, کوتاه کننده لینک, اپلیکیشن کوتاه کننده لینک, برنامه کوتاه کننده لینک برای اندروید, نرم افزار کوتاه کننده لینک پیشرفته ویندوز, دانلود برنامه کوتاه کننده لینک, url shortener, link shortener, custom url shortener, free url shortener, shorten, short url">
    <title>Link shorter API</title>
</head>

<body>
    <div class="amp-content">
        <div class="amp-content-title">نحوه استفاده از API کوتاه کننده لینک</div>
        سلام خدمت دوستان عزیز<div>در این قسمت توضیحی در مورد نحوه استفاده از API کوتاه کننده لینک قراره بدم</div>
        <div>خب قدم اول شما باید برای این API <span class="highlited-text">ثبت نام</span> کنید.(<a href="#authtab">فرم ثبت نام</a> پایین همین صفحه قرار دارد.)</div>
        <div><br></div>
        <div class="content-img-con">
            <img src="assets/img/register.png" alt="">
        </div>
        <div class="content-img-des">ثبت نام</div>
        <div><br></div>
        <div class="content-img-con">
        <img src="assets/img/registered.png" alt="">
        </div>
        <div class="content-img-des">دریافت توکن</div>
        <div>سپس شما باید ایمیل خود را تایید بفرمایید تا توکن فعال شود.<br></div>
        <div><br></div>
        <div class="content-img-con">
        <img src="assets/img/email.png" alt="">
        </div>
        <div class="content-img-des">ایمیل تایید</div>
        <div><br></div>
        <div class="content-img-con">
        <img src="assets/img/ok.png" alt="">
        </div>
        <div class="content-img-des">تایید ایمیل</div>
        <div>اگر برای شما ایمیل ارسال نشد میتوانید با وارد کردن<span class="text-color"> ایمیل</span> و <span class="text-color">رمز عبور</span> در قسمت <span class="highlited-text">فراموشی توکن</span> ایمیل تایید را مجددا دریافت کنید و حساب خود را تایید کنید و پس از تایید ایمیل با وارد کردن مجدد ایمیل و رمز عبور توکن شما <span class="text-color">آپدیت</span> می شود.</div>
        <div><br></div>
        <div class="content-img-con">
        <img src="assets/img/tokenforget.png" alt="">
        </div>
        <div class="content-img-des">فراموشی توکن</div>
        <div>خب حالا که ثبت نام شما انجام شد بریم و نحوه استفاده از API رو بررسی کنیم:</div>
        <div>برنامه ای که من برای ارسال درخواست استفاده میکنم برنامه <span class="text-color">Advanced REST client</span> هستش ، البته برنامه های مشابه دیگه ای هم مثل Postman هم هست ، این برنامه ها برای آزمایش API هستن خب قدم اول باید هدر&nbsp;<span class="highlited-text">Content-Type</span> رو&nbsp;<span class="highlited-text">application/json</span> قرار بدیم مانند تصویر زیر</div>
        <div><br></div>
        <div class="content-img-con">
        <img src="assets/img/header.png" alt="">
        </div>
        <div class="content-img-des">تنظیم هدر</div>
        <div>سپس جیسونی مانند جیسون زیر باید ارسال کنیم تا لینک کوتاه شود:</div>
        <div><br></div>
        <div class="code-toolbar">
            <pre class="line-numbers"><code class="language-cpp">{
  "username": "wwwwwww",
  "token": "ada9810027a9b4acfd771153714b56cbb7ad881c",
  "link": "https://blog.elearnsecurity.com/free-resources-to-legally-practice-ethical-hacking.html"
}</code></pre>
        </div>
        <div><br></div>
        <div>به جای&nbsp;https://blog.elearnsecurity.com/free-resources-to-legally-practice-ethical-hacking.html باید لینکی که میخواهید کوتاه شود را قرار دهید.</div>
        <div>یا با برنامه ای که گفتم مانند تصویر :</div>
        <div><br></div>
        <div class="content-img-con">
        <img src="assets/img/body.png" alt="">
        </div>
        <div class="content-img-des">تنظیم body</div>
        <div>و نتیجه کار :</div>
        <div><br></div>
        <div class="content-img-con">
        <img src="assets/img/result1.png" alt="">
        </div>
        <div class="content-img-des">لینک کوتاه شده</div>
        <div><br></div>
        <div class="content-img-con">
        <img src="assets/img/result2.png" alt="">
        </div>
        <div class="content-img-des">لینک کوتاه شده</div>
        <div><br></div><hr>


    </div>



    <div id="authcontainer">
        <div id="notice">توضیحات:</div>
        <div id="notice-items">
            <ul>
                <li>نام کاربری شما باید حداقل ۴ کاراکتر و حداکثر ۱۲ کاراکتر باشد</li>
                <li>برای نام کاربری از کاراکتر های #,@,$,%,^,&,*,+,...نمی توانید استفاده کنید</li>
                <li>پسورد باید حداقل 9 کاراکتر شامل حداقل یک رقم عددی و حداقل یک کاراکتر لاتین کوچک و حداقل یه کاراکتر لاتین بزرگ باشد</li>
                <li>در صورتی فراموشی توکن میتوانید با ایمیل و رمز خود توکن جدید بگیرید</li>
                <li>درصورتی که ایمیل برای شما ارسال نشد از قسمت فراموشی توکن میتوانید ایمیل خود را تایید کنید.</li>
            </ul>
        </div>
        <form action="app.php" method="post" id="myform">
            <div id="authtab">
                <div id="registertab" style="background: #f05a24;">ثبت نام</div>
                <div id="paneltab">فراموشی توکن</div>
            </div>
            <div id="signup_div">
                <div class="form_input_div" id="username"><input type="text" name="username" placeholder="نام کاربری"></div>
                <div class="form_input_div" id="email"><input type="email" name="email" placeholder="ایمیل"></div>
                <div class="form_input_div" id="pass1"><input type="password" name="pass1" placeholder="رمز عبور"></div>
                <div class="form_input_div" id="pass2"><input type="password" name="pass2" placeholder="تکرار رمز عبور"></div>
                <input type="hidden" name="anticsrf" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" id="submitmode" name="mode" value="register">
            </div>
            <div id="captcha-con">
                <div class="g-recaptcha" data-sitekey="6LeIr8AZAAAAAMMuVHlvRPrLKfMfAHIKSd2hwE91" data-theme="dark"></div>
            </div>
            <div id="form_input_submit" data-mode="register"><input type="button" value="ثبت نام"></div>
            <div id="result" style="display: none;"></div>
            <hr><br>
        </form>
    </div>


    <div id="tags-con">

        <div class="mini-title">زبان ها و تکنولوژی ها : </div>
        <div class="amp-tags amp-tags-eng">html5</div>
        <div class="amp-tags amp-tags-eng">css</div>
        <div class="amp-tags amp-tags-eng">javascript</div>
        <div class="amp-tags amp-tags-eng amp-tags-main">php</div>
        <div class="amp-tags amp-tags-eng">ajax</div>
        <div class="amp-tags amp-tags-eng">mysql</div>
        <div class="amp-tags amp-tags-eng">prism.js</div>
        <div class="amp-tags amp-tags-eng">PHPMailer</div>
        <div class="amp-tags amp-tags-eng">recaptcha</div>

    </div>

    <script src="assets/js/prism.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</body>

</html>