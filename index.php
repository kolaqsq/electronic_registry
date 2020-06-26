<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0"
          name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <link href="css/main.css" rel="stylesheet">
    <link href="css/fonts.css" rel="stylesheet">

    <title>Электронная регистратура</title>
</head>
<body class="page">
<header class="hero">
    <div class="hero__acrylic">
        <h1 class="hero__title">Электронная регистратура</h1>
        <span class="hero__description">Рязанская область</span>
        <?php
        try {
            $conn = new PDO("mysql:host=std-mysql;dbname=std_950", "std_950", "901109qsq");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo '<div class="hero__buttons">
                <a class="hero__button" href="index.php">Записаться на прием</a>
                <a class="hero__button" href="index.php">Удалить запись</a>
            </div>';
        } catch (PDOException $e) {
            echo '<br><span class="hero__description hero__description_warning">Ошибка подключения к базе данных: ' . $e->getMessage() . '</span>';
        }
        ?>
    </div>
</header>
</body>
</html>