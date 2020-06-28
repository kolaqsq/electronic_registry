<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0"
          name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../js/main.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>

    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/fonts.css" rel="stylesheet">

    <title>Электронная регистратура. Отмена записи</title>
</head>
<body class="page" onload="show()">
<main class="main">
    <div class="main__header">
        <a class="main__back material-icons-round" href="delete.php" onclick="hide()">keyboard_arrow_left</a>
        <h2 class="main__mode">Отмена записи</h2>
    </div>
    <h3 class="step__title">Вы успешно отменили запись</h3>
    <article class="step">
        <?php
        if (isset($_POST['id'])) {
            require 'database.php';
            $database = connect();

            $query = $database->prepare("select ELREG_appointments.date_id, time_id
                from ELREG_appointments
                         join ELREG_clinics Ec on ELREG_appointments.clinic_id = Ec.id
                         join ELREG_specializations Es on ELREG_appointments.specialization_id = Es.id
                         join ELREG_available_dates Ead on Ec.id = Ead.clinic_id
                         join ELREG_available_times Eat on Ead.id = Eat.date_id
                where ELREG_appointments.id = ?
                  and Ec.id = ELREG_appointments.clinic_id
                  and Es.id = ELREG_appointments.specialization_id
                  and Ead.id = ELREG_appointments.date_id
                  and Eat.id = time_id");
            $query->execute([$_POST['id']]);
            $result = $query->fetch();
            $date_id = $result['date_id'];
            $time_id = $result['time_id'];

            $query = $database->prepare("delete from ELREG_appointments where id = ?");
            $query->execute([$_POST['id']]);

            $query = $database->prepare("select * from ELREG_available_times where date_id = ? and available = true");
            $query->execute([$date_id]);

            if (!$query->fetch()) {
                $query = $database->prepare("update ELREG_available_dates set available = true where id = ?");
                $query->execute([$date_id]);
            }

            $query = $database->prepare("update ELREG_available_times set available = true where id = ?");
            $query->execute([$time_id]);

            header('Refresh:0; url=delete_finish.php');
        }
        ?>
        <div class="step__even">
            <a class="step__button" href="../index.php" onclick="hide()">На главную</a>
        </div>
    </article>
</main>
</body>
</html>