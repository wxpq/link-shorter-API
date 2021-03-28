document.getElementById("paneltab").addEventListener("click", () => {
    document.getElementById("registertab").style.background = "";
    document.getElementById("paneltab").style.background = "#f05a24";
    document.getElementById("pass2").style.display = "none";
    document.getElementById("username").style.display = "none";
    document.getElementById("form_input_submit").dataset.mode = "gettoken";
    document.getElementById("submitmode").value = "gettoken";
    document.querySelector("#form_input_submit>input").value = "دریافت توکن";
    document.getElementById("registertab").addEventListener("click", () => {
        document.getElementById("registertab").style.background = "#f05a24";
        document.getElementById("paneltab").style.background = "";
        document.getElementById("pass2").style.display = "block";
        document.getElementById("username").style.display = "block";
        document.getElementById("form_input_submit").dataset.mode = "register";
        document.getElementById("submitmode").value = "register";
        document.querySelector("#form_input_submit>input").value = "ثبت نام";
    });
});

document.querySelector("#form_input_submit>input").addEventListener("click", () => {
    var username = document.querySelector("#username>input").value;
    var email = document.querySelector("#email>input").value;
    var password1 = document.querySelector("#pass1>input").value;
    var password2 = document.querySelector("#pass2>input").value;

    if (document.getElementById("form_input_submit").dataset.mode == "register") {

        if (username != "" && email != "" && password1 != "" && password2 != "") {
            if (username.match(/(\w+){4,12}/)) {
                if (password1 === password2) {
                    if (email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {


                        var xhr = new XMLHttpRequest();
                        form = document.getElementById("myform");
                        xhr.open("post", "register.php", true);
                        xhr.setRequestHeader('Content-type', 'application/json');
                        let fd = new FormData(form);
                        let object = {};
                        fd.forEach((value, key) => { object[key] = value });
                        let json = JSON.stringify(object);
                        xhr.send(json);

                        xhr.onreadystatechange = () => {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                document.getElementById("result").innerHTML = ``;
                                document.getElementById("result").style.display = "block";
                                document.getElementById("result").innerText = unescape(JSON.parse(xhr.responseText)['message']);
                                if (JSON.parse(xhr.responseText)['token'] != undefined) {
                                    document.getElementById("result").style.display = "block";
                                    document.getElementById("result").style.background = "green";
                                    document.getElementById("result").innerHTML += `<br>توکن شما👇<br><span style="font-family:monospace">${JSON.parse(xhr.responseText)['token']}</span>`;
                                } else {
                                    setTimeout(() => {
                                        document.getElementById("result").style.background = "rgba(235, 4, 4, 0.514)";
                                        document.getElementById("result").style.display = "none";
                                    }, 5000);
                                }
                                grecaptcha.reset();
                                document.querySelector("#username>input").value = '';
                                document.querySelector("#email>input").value = '';
                                document.querySelector("#pass1>input").value = '';
                                document.querySelector("#pass2>input").value = '';

                            }
                        }



                    } else {
                        document.getElementById("result").style.display = "block";
                        document.getElementById("result").innerText = "ایمیل نامعتبر است";
                        setTimeout(() => {
                            document.getElementById("result").style.background = "rgba(235, 4, 4, 0.514)";
                            document.getElementById("result").style.display = "none";
                        }, 5000);
                    }
                } else {
                    document.getElementById("result").style.display = "block";
                    document.getElementById("result").innerText = "پسورد ها برابر نیستند!";
                    setTimeout(() => {
                        document.getElementById("result").style.background = "rgba(235, 4, 4, 0.514)";
                        document.getElementById("result").style.display = "none";
                    }, 5000);
                }
            } else {
                document.getElementById("result").style.display = "block";
                document.getElementById("result").innerText = "لطفا یوزر نیم را طبق توضیحات انتخاب کنید";
                setTimeout(() => {
                    document.getElementById("result").style.background = "rgba(235, 4, 4, 0.514)";
                    document.getElementById("result").style.display = "none";
                }, 5000);
            }

        } else {
            document.getElementById("result").style.display = "block";
            document.getElementById("result").innerText = "لطفا فرم را طبق توضیحات بالا پر کنید";
            setTimeout(() => {
                document.getElementById("result").style.background = "rgba(235, 4, 4, 0.514)";
                document.getElementById("result").style.display = "none";
            }, 5000);
        }

    }








    if (document.getElementById("form_input_submit").dataset.mode == "gettoken") {

        if (email != "" && password1 != "") {
            if (email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {

                var xhr = new XMLHttpRequest();
                form = document.getElementById("myform");
                xhr.open("post", "register.php", true);
                xhr.setRequestHeader('Content-type', 'application/json');
                let fd = new FormData(form);
                let object = {};
                fd.forEach((value, key) => { object[key] = value });
                delete object["username"];
                delete object["pass2"];
                let json = JSON.stringify(object);
                xhr.send(json);

                xhr.onreadystatechange = () => {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById("result").innerHTML = ``;
                        document.getElementById("result").style.display = "block";
                        document.getElementById("result").innerText = unescape(JSON.parse(xhr.responseText)['message']);
                        if (JSON.parse(xhr.responseText)['token'] != undefined) {
                            document.getElementById("result").style.display = "block";
                            document.getElementById("result").style.background = "green";
                            document.getElementById("result").innerHTML += `<br>توکن شما👇<br><span style="font-family:monospace">${JSON.parse(xhr.responseText)['token']}</span>`;
                        } else {
                            setTimeout(() => {
                                document.getElementById("result").style.background = "rgba(235, 4, 4, 0.514)";
                                document.getElementById("result").style.display = "none";
                            }, 5000);
                        }
                        grecaptcha.reset();


                    }
                }

            } else {
                document.getElementById("result").style.display = "block";
                document.getElementById("result").innerText = "ایمیل نامعتبر است";
                setTimeout(() => {
                    document.getElementById("result").style.background = "rgba(235, 4, 4, 0.514)";
                    document.getElementById("result").style.display = "none";
                }, 5000);
            }



        } else {
            document.getElementById("result").style.display = "block";
            document.getElementById("result").innerText = "لطفا فرم را طبق توضیحات بالا پر کنید";
            setTimeout(() => {
                document.getElementById("result").style.background = "rgba(235, 4, 4, 0.514)";
                document.getElementById("result").style.display = "none";
            }, 5000);
        }

    }

});