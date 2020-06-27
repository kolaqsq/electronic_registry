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
        <?php
        echo '<a class="main__back material-icons-round" href="customer_form.php?clinic_id=' . $_GET['clinic_id'] .
            '&specialization_id=' . $_GET['specialization_id'] .
            '&date_id=' . $_GET['date_id'] .
            '&time_id=' . $_GET['time_id'] . '">keyboard_arrow_left</a>';
        ?>
        <h2 class="main__mode">Запись на приём</h2>
    </div>
    <h3 class="step__title">Вы успешно записались на приём</h3>
    <article class="step">
        <section class="record">
            <?php
            require 'database.php';
            $database = connect();

            if (isset($_POST['name'])) {
                $query = $database->query("select max(id) from ELREG_appointments");
                $max_id = $query->fetch();
                $id = $max_id['max(id)'] + 1;

                $query = $database->prepare("insert into ELREG_appointments
                (id, clinic_id, specialization_id, date_id, time_id,
                customer_name, customer_birthday, customer_phone, `customer_e-mail`)
                values (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $query->execute([$id, $_GET['clinic_id'], $_GET['specialization_id'], $_GET['date_id'],
                    $_GET['time_id'], $_POST['name'], $_POST['birth'], $_POST['phone'], $_POST['e-mail']]);

                $query = $database->prepare("update ELREG_available_times set available = false where id = ?");
                $query->execute([$_GET['time_id']]);

                $query = $database->prepare("select * from ELREG_available_times where date_id = ? and available = true");
                $query->execute([$_GET['date_id']]);

                if (!$query->fetch()) {
                    $query = $database->prepare("update ELREG_available_dates set available = false where id = ?");
                    $query->execute([$_GET['date_id']]);
                }

                header('Refresh:0; url=finish.php?id=' . $id . '&clinic_id=' . $_GET['clinic_id'] .
                    '&specialization_id=' . $_GET['specialization_id'] .
                    '&date_id=' . $_GET['date_id'] .
                    '&time_id=' . $_GET['time_id']);
            }
            ?>

            <h3 class="record__title">Данные о записи</h3>
            <?php
            if (isset($_GET['id'])) {
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
              and Ec.id = ?
              and Es.id = ?
              and Ead.id = ?
              and Eat.id = ?");
                $query->execute([$_GET['id'], $_GET['clinic_id'], $_GET['specialization_id'], $_GET['date_id'],
                    $_GET['time_id']]);

                while ($row = $query->fetch()) {
                    echo '<span class="record__header">Номер записи</span>
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
                    
                </section>';
                    if ($row["customer_e-mail"] != '')
                        echo '<h3 class="step__title">Данные о записи отправлены на адрес ' . $row["customer_e-mail"] . '</h3>';

                }
            }

            ?>
            <div class="step__even">
                <!--            <input class="step__button" type="submit" value="РАСПЕЧАТАТЬ">-->
                <a class="step__button" href="index.php">НА ГЛАВНУЮ</a>
            </div>
    </article>
</main>
</body>
</html>