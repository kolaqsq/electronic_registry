<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0"
          name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>

    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/fonts.css" rel="stylesheet">

    <title>Электронная регистратура. Запись на приём</title>
</head>
<body class="page">
<main class="main">
    <div class="main__header">
        <a class="main__back material-icons-round" href="../index.php">keyboard_arrow_left</a>
        <h2 class="main__mode">Запись на приём</h2>
    </div>
    <article class="step">
        <div class="step__header">
            <label class="step__title" for="search-1">Шаг 1. Выбор клиники</label>
<!--            <input class="step__search" id="search-1" placeholder="Поиск" type="text">-->
        </div>
        <section class="list">
            <?php
            require 'database.php';
            $database = connect();
            $query = $database->query("select * from ELREG_clinics");

            while ($row = $query->fetch()) {
                echo '<a class="item" href="specializations.php?clinic_id=' . $row["id"] . '">
                    <span class="item__title">' . $row["clinic_name"] . '</span>
                    <span class="item__phone">' . $row["clinic_phone"] . '</span>
                    <span class="item__address">' . $row["clinic_address"] . '</span>
                </a>';
            }
            ?>
        </section>
    </article>
</main>
</body>
</html>