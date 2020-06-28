<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0"
          name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="js/main.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>

    <link href="css/main.css" rel="stylesheet">
    <link href="css/fonts.css" rel="stylesheet">

    <title>Электронная регистратура</title>
</head>
<body class="page" onload="show()">
<header class="hero">
    <div class="hero__acrylic">
        <h1 class="hero__title">Электронная регистратура</h1>
        <span class="hero__description">Рязанская область</span>
        <?php
        require 'php/database.php';
        try {
            $database = connect();
            echo '<div class="hero__buttons">
                <a class="hero__button" href="php/clinics.php" onclick="hide()">Записаться на приём</a>
                <a class="hero__button" href="php/delete.php" onclick="hide()">Отменить запись</a>
            </div>';
        } catch (PDOException $e) {
            echo '<br><span class="hero__description hero__description_warning">Ошибка подключения к базе данных: ' . $e->getMessage() . '</span>';
        }
        $database = null
        ?>
    </div>
</header>
</body>
</html>