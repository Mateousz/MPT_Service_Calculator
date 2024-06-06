<?php
session_start();
$conn = new mysqli("localhost", "root", "", "mpt_calculator");
if ($conn->connect_error) {
    die("Connection failed!" . $conn->connect_error);
}

function Login($username, $password)
{
    global $conn;
    $q = "SELECT * FROM users WHERE username = ?";
    $query = $conn->prepare($q);
    $query->bind_param("s", $username);
    $query->execute();
    $user = $query->get_result();
    if (mysqli_num_rows($user) == 1) {
        $founduser = $user->fetch_assoc();
        if (password_verify($password, $founduser['password'])) {
            $_SESSION['userid'] = $founduser['id'];
            $_SESSION['admin'] = $founduser['admin'];
            echo '<script>
                    alert("Sikeres Bejelentkezés! Üdvözöljük!");
                    window.location.href = "index.php";
                </script>';
        } else {
            echo '<script>
                    alert("Hibás jelszót adott meg!");
            </script>';
            exit();
        }
    } else {
        echo '<script>
                    alert("Hibás felhasználónevet adott meg!");
            </script>';
        exit();
    }
}
function Reg($username, $password, $fullname, $company, $tax, $address, $email, $tel)
{
    global $conn;
    $q = "SELECT * FROM users WHERE username = ?";
    $query = $conn->prepare($q);
    $query->bind_param('s', $username);
    $query->execute();
    $user = $query->get_result();
    if (mysqli_num_rows($user) == 0) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $q = "INSERT INTO users VALUES(id,?,?,?,?,?,?,?,?,0)";
        $query = $conn->prepare($q);
        $query->bind_param('ssssssss', $username, $hashed_password, $fullname, $company, $tax, $address, $email, $tel);
        if ($query->execute()) {
            echo '<script>
                    alert("Sikeres Regisztráció! Átirányítás a bejelentkezéshez...");
                    window.location.href = "verify.php";
                </script>';
        } else {
            echo '<script>
                    alert("Error: ' . $query->error . '");
                </script>';
        }
        $query->close();
    }
}
