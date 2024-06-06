<?php
require "functions.php";
if (isset($_POST['login_btn'])) {
    Login($_POST['login_username'], $_POST['login_password']);
}
if (isset($_POST['reg_btn'])) {
    Reg($_POST['username'], $_POST['password'], $_POST['fullname'],$_POST['companyname'],$_POST['taxnum'],$_POST['address'],$_POST['email'],$_POST['tel']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/verif_style.css">
    <link rel="stylesheet" href="css/all_style.css">
    <title>Document</title>
</head>
<body>
<form class="verify_data" id="loginForm" method="post" action="verify.php">
    <h3>Bejelentkezés</h3>
    <input type="text" name="login_username" id="login_username" placeholder="Felhasználónév" required>
    <div><input type="password" name="login_password" id="login_password" placeholder="Jelszó" required><span id="eye-spot" class="unhighlightable">👁</span></div>
    <input type="submit" name="login_btn" id="login_btn" value="Bejelentkezés">
    <a onclick="openForm('reg')">Ugrás a Regisztrációhoz</a>
</form>
<form class="verify_data" id="regForm" method="post" action="verify.php">
    <h3>Regisztráció</h3>
    <input type="text" name="username" id="username" placeholder="Felhasználónév" required>
    <label><span id="taken-check"></span></label>
    <input type="text" name="fullname" id="fullname" placeholder="Teljes Név" required>
    <input type="text" name="companyname" id="companyname" placeholder="Cégnév" required>
    <input type="text" name="taxnum" id="taxnum" placeholder="Adóazonosító" required>
    <input type="text" name="address" id="address" placeholder="Számlázási cím" required>
    <input type="text" name="email" id="email" placeholder="E-mail cím" required>
    <input type="text" name="tel" id="tel" placeholder="Telefonszám" required>
    <input type="password" name="password" id="password" placeholder="Jelszó" required>
    <label id="req-len">A jelszó legalább 8 karakter hosszú legyen!<span id="length-check"></span></label>
    <label id="req-cap">A jelszó tartalmazzon minimum egy nagy betűt!<span id="upper-check"></span></label>
    <label id="req-num">A jelszó tartalmazzon minimum egy számot!<span id="number-check"></span></label>
    <input type="password" name="password_re" id="password_re" placeholder="Jelszó Újra" required>
    <input type="submit" name="reg_btn" id="reg_btn" value="Regisztráció!" hidden>
    <a onclick="openForm('login')">Ugrás a Bejelentkezéshez</a>
</form>
</body>
</html>
<script>
    var loginForm = document.getElementById("loginForm");
    var regForm = document.getElementById("regForm");
    regForm.style.display = "none";

    function openForm(form) {
        if (form == "login") {
            loginForm.style.display = "flex";
            regForm.style.display = "none";
        } else {
            loginForm.style.display = "none";
            regForm.style.display = "flex";
        }
    }
    //Login Handler
    document.getElementById('eye-spot').addEventListener('click', (e) => {
        var eye = document.getElementById('eye-spot');
        var password = document.getElementById('login_password');
        if(password.type === "password"){
            eye.innerHTML = "🕶";
            password.type = "text";
        }else{
            eye.innerHTML = "👁";
            password.type = "password";
        }
    });
    //Registration Handler
    document.getElementById('username').addEventListener('keyup', (e) => {
        var un = document.getElementById('username').value;
        var un_box = document.getElementById('username');
        var taken_check = document.getElementById('taken-check');
        var taken = false;
        <?php
        $users = $conn->query("SELECT * FROM users");
        while ($user = $users->fetch_assoc()) { ?>
            var user = <?php echo json_encode($user) ?>;
            console.log(user);
            if (un.length >= 4) {
                console.log(user['username']);
                console.log(un);
                if (user['username'] == un) {
                    taken = true;
                    un_box.style.border = "2px solid red";
                    taken_check.innerHTML = 'A felhasználónév már foglalt! ';
                }
            } else {
                un_box.style.border = "2px solid red";
                taken_check.style.color = "#f00";
                document.getElementById('taken-check').innerHTML = 'A felhasználónév legalább 4 karakter hosszú legyen!';
            }
            if (un.length >= 4 && !taken) {
                taken_check.innerHTML = '';
                un_box.style.border = "2px solid lime";
            }
        <?php } ?>
    });

    function containsUppercase(str) {
        return /[A-Z]/.test(str);
    }

    function containsNumber(str) {
        return /\d/.test(str);
    }
    document.getElementById('')
    var length = false;
    var upper = false;
    var number = false;
    var passmatch = false;
    document.getElementById('password').addEventListener('keyup', (e) => {
        var password = document.getElementById('password').value;
        if (password.length >= 8) {
            document.getElementById('length-check').innerHTML = '✔ ';
            document.getElementById('req-len').style.color = '#0f0';
            length = true;
            console.log("Length: " + length);
        } else {
            document.getElementById('length-check').innerHTML = '';
            document.getElementById('req-len').style.color = '#000';
            length = false;
            console.log("Length: " + length);
        }

        if (containsUppercase(password)) {
            document.getElementById('upper-check').innerHTML = '✔ ';
            document.getElementById('req-cap').style.color = '#0f0';
            upper = true;
            console.log("Upper: " + upper);
        } else {
            document.getElementById('upper-check').innerHTML = '';
            document.getElementById('req-cap').style.color = '#000';
            upper = false;
            console.log("Upper: " + upper);
        }
        if (containsNumber(password)) {
            document.getElementById('number-check').innerHTML = '✔ ';
            document.getElementById('req-num').style.color = '#0f0';
            number = true;
            console.log("Number: " + number);
        } else {
            document.getElementById('number-check').innerHTML = '';
            document.getElementById('req-num').style.color = '#000';
            number = false;
            console.log("Number: " + number);
        }
    });
    document.getElementById('password_re').addEventListener('keyup', (e) => {
        var password = document.getElementById('password').value;
        var passwordre = document.getElementById('password_re').value;
        var pass_box1 = document.getElementById('password');
        var pass_box2 = document.getElementById('password_re');
        if (password != passwordre) {
            pass_box1.style.border = "2px solid red";
            pass_box2.style.border = "2px solid red";
            passmatch = false;
            console.log("Pass: " + passmatch);
        } else {
            pass_box1.style.border = "2px solid lime";
            pass_box2.style.border = "2px solid lime";
            passmatch = true;
            console.log("Pass: " + passmatch);

        }
        if (passwordre == "") {
            pass_box1.style.border = "2px solid #333";
            pass_box2.style.border = "2px solid #333";
        }
        if (length && upper && number && passmatch) {
            document.getElementById('reg_btn').hidden = false;
        }
    });
</script>