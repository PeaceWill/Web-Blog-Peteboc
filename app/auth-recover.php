<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <link rel="shortcut icon" href="./assets/img/logo/cropped-logo-transparent.png" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link rel="stylesheet" href="./assets/css/recover-pw.css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        $domain = $_SERVER['SERVER_NAME'];
    ?>
    <form action="http://9f2590ba9f1e.ngrok.io//Web-Blog-Peteboc/app/controller/client/mail.php" type="GET">
        <input type="hidden" name="token" value="<?php echo $_GET['token'] ?>">
        <input type="hidden" name="e" value="<?php echo $_GET['e'] ?>">
        <input type="hidden" name="email" value="<?php echo $_GET['email'] ?>">
        <input type="submit" style="visibility: hidden">
    </form>
</body>
<script>
    window.onload = () => {
        document.querySelector('input[type=submit]').click();
    }
</script>
</html>
