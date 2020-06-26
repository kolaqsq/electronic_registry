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
        <a class="main__back material-icons-round"
           href="specializations.php?clinic_id=<?php echo $_GET['clinic_id'] ?>">keyboard_arrow_left</a>
        <h2 class="main__mode">Запись на приём</h2>
    </div>
    <article class="step">
        <h3 class="step__title">Шаг 3. Выбор дня и времени посещения</h3>
        <?php
        require 'database.php';
        $database = connect();
        $query = $database->prepare("select specialization_name from ELREG_specializations where id = ?");
        $query->execute([$_GET['specialization_id']]);

        while ($row = $query->fetch()) {
            echo '<span class="step__specialization">' . $row["specialization_name"] . '</span>';
        }
        ?>
        <div class="timepicker">
            <?php
            $query = $database->prepare("select id, available_date from ELREG_available_dates where clinic_id = ? and specialization_id = ?");
            $query->execute([$_GET['clinic_id'], $_GET['specialization_id']]);

            while ($row = $query->fetch()) {
                if (isset($_GET['date_id'])) {
                    if ($_GET['date_id'] == $row['id'])
                        echo '<a class="timepicker__time timepicker__time_selected" href="dates.php?clinic_id=' . $_GET['clinic_id'] .
                            '&specialization_id=' . $_GET['specialization_id'] .
                            '&date_id=' . $row['id'] . '">' . $row["available_date"] . '</a>';
                    else echo '<a class="timepicker__time" href="dates.php?clinic_id=' . $_GET['clinic_id'] .
                        '&specialization_id=' . $_GET['specialization_id'] .
                        '&date_id=' . $row['id'] . '">' . $row["available_date"] . '</a>';
                } else echo '<a class="timepicker__time" href="dates.php?clinic_id=' . $_GET['clinic_id'] .
                    '&specialization_id=' . $_GET['specialization_id'] .
                    '&date_id=' . $row['id'] . '">' . $row["available_date"] . '</a>';
            }
            ?>
        </div>
        <?php
        if (isset($_GET['date_id'])) {
            $query = $database->prepare("select available_date from ELREG_available_dates where id = ?");
            $query->execute([$_GET['date_id']]);

            while ($row = $query->fetch()) {
                echo '<h3 class="step__title">Запись на ' . $row["available_date"] . '</h3>';
            }

            $query = $database->prepare("select id, available_time from ELREG_available_times where date_id = ?");
            $query->execute([$_GET['date_id']]);

            echo '<div class="timepicker">';
            while ($row = $query->fetch()) {
                echo '<a class="timepicker__time" href="personal.php?clinic_id=' . $_GET['clinic_id'] .
                    '&specialization_id=' . $_GET['specialization_id'] .
                    '&date_id=' . $_GET['date_id'] .
                    '&time_id=' . $row['id'] . '">' . $row["available_time"] . '</a>';
            };
            echo '</div>';
        }
        ?>
    </article>
</main>
</body>
</html>