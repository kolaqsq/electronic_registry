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
        <a class="main__back material-icons-round" href="../index.php" onclick="hide()">keyboard_arrow_left</a>
        <h2 class="main__mode">Отмена записи</h2>
    </div>
    <article class="step">
        <form action="delete.php" class="personal" method="post">
            <label class="personal__title" for="id">Номер записи</label>
            <input class="personal__input" id="id" name="id" placeholder="Введите номер записи" required
                   type="text">

            <input class="step__button" type="submit" value="Проверить"  onclick="hide()">
        </form>
        <?php
        if (isset($_POST['id'])) {
            require 'database.php';
            $database = connect();

            $query = $database->prepare("select ELREG_appointments.id,
                       clinic_name,
                       specialization_name,
                       available_date,
                       available_time,
                       customer_name,
                       customer_birthday,
                       customer_phone,
                       `customer_e-mail`
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

            while ($row = $query->fetch()) {
                echo '<form action="delete_finish.php" class="record" method="post">
                    <h3 class="record__title">Данные о записи</h3>

                    <span class="record__header">Номер записи</span>
                    <span class="record__description">' . $row["id"] . '</span>
                    
                    <span class="record__header">ФИО пациента</span>
                    <span class="record__description">' . $row["customer_name"] . '</span>
                    
                    <span class="record__header">Дата рождения</span>
                    <span class="record__description">' . $row["customer_birthday"] . '</span>
                    
                    <span class="record__header">Телефон</span>
                    <span class="record__description">' . $row["customer_phone"] . '</span>
                    
                    <span class="record__header">Клиника</span>
                    <span class="record__description">' . $row["clinic_name"] . '</span>
                    
                    <span class="record__header">Услуга</span>
                    <span class="record__description">' . $row["specialization_name"] . '</span>
                    
                    <span class="record__header">Дата и время посещения</span>
                    <span class="record__description">' . $row["available_date"] . ', ' . $row["available_time"] . '</span>
                    
                    <input type="text" name="id" style="display: none" value="' . $_POST['id'] . '">
                                        
                    <input class="step__button" type="submit" value="Отменить запись"  onclick="hide()">
                    
                    </section>';
            }
        }
        ?>
</main>
</body>
</html>