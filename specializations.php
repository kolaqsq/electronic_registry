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

    <title>Электронная регистратура. Запись на приём</title>
</head>
<body class="page">
<main class="main">
    <div class="main__header">
        <a class="main__back material-icons-round" href="clinics.php">keyboard_arrow_left</a>
        <h2 class="main__mode">Запись на приём</h2>
    </div>
    <article class="step">
        <div class="step__header">
            <label class="step__title" for="search-2">Шаг 2. Выбор специализации</label>
<!--            <input class="step__search" id="search-2" placeholder="Поиск" type="text">-->
        </div>
        <section class="list">
            <?php
            require 'database.php';
            $database = connect();
            $query = $database->prepare("select id, specialization_name from ELREG_specializations
                join ELREG_clinics_specializations Ecs on ELREG_specializations.id = Ecs.specialization_id
                where clinic_id = ?");
            $query->execute([$_GET['clinic_id']]);

            while ($row = $query->fetch()) {
                echo '<a class="item" href="dates.php?clinic_id=' . $_GET['clinic_id'] . '&specialization_id=' . $row["id"] . '">
                    <span class="item__title">' . $row["specialization_name"] . '</span>
                </a>';
            }
            ?>
        </section>
    </article>
</main>
</body>
</html>