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
        <?php
        echo '<a class="main__back material-icons-round" href="dates.php?clinic_id=' . $_GET['clinic_id'] .
            '&specialization_id=' . $_GET['specialization_id'] .
            '&date_id=' . $_GET['date_id'] . '">keyboard_arrow_left</a>';
        ?>
        <h2 class="main__mode">Запись на приём</h2>
    </div>
    <form action="<?php echo 'finish.php?clinic_id=' . $_GET['clinic_id'] .
                    '&specialization_id=' . $_GET['specialization_id'] .
                    '&date_id=' . $_GET['date_id'] .
                    '&time_id=' . $_GET['time_id'] ?>" class="step" method="post">
        <div class="step__columns">
            <section class="personal">
                <h3 class="personal__title">Шаг 4. Введите данные о себе</h3>
                <label class="personal__label" contenteditable="true" for="name">ФИО<span
                            style="color: #EF5350">*</span></label>
                <input class="personal__input" id="name" name="name" placeholder="Введите Ваше ФИО" required
                       type="text">

                <label class="personal__label" contenteditable="true" for="birth">Дата рождения<span
                            style="color: #EF5350">*</span></label>
                <input class="personal__input" id="birth" name="birth" placeholder="__.__.____" required type="date">

                <label class="personal__label" contenteditable="true" for="phone">Контактный телефон<span
                            style="color: #EF5350">*</span></label>
                <input class="personal__input" id="phone" name="phone" placeholder="+7 (___) ___-__-__" required
                       type="tel">

                <label class="personal__label" contenteditable="true" for="e-mail">Контактный e-mail</label>
                <input class="personal__input" id="e-mail" name="e-mail" placeholder="Введите Ваш e-mail" type="email">

                <label class="personal__confirmation" for="data">
                    <input class="personal__checkbox" id="data" required type="checkbox">
                    <span class="personal__checkmark material-icons-round"></span>
                    <span class="personal__label-check">
                        Даю согласие на обработку персональных данных<span
                                style="color: #EF5350">*</span>
                    </span>
                </label>
            </section>
            <section class="record">
                <h3 class="record__title">Данные о записи</h3>
                <?php
                require 'database.php';
                $database = connect();
                $query = $database->prepare("select clinic_name from ELREG_clinics where id = ?");
                $query->execute([$_GET['clinic_id']]);

                while ($row = $query->fetch()) {
                    echo '<span class="record__header">Клиника</span>
                    <span class="record__description">' . $row["clinic_name"] . '</span>';
                }

                $query = $database->prepare("select specialization_name from ELREG_specializations where id = ?");
                $query->execute([$_GET['specialization_id']]);

                while ($row = $query->fetch()) {
                    echo '<span class="record__header">Услуга</span>
                    <span class="record__description">' . $row["specialization_name"] . '</span>';
                }

                $query = $database->prepare("select available_date, available_time
                    from ELREG_available_dates
                             join ELREG_available_times Eat on ELREG_available_dates.id = Eat.date_id
                    where Eat.id = ? and ELREG_available_dates.id = ?");
                $query->execute([$_GET['time_id'], $_GET['date_id']]);

                while ($row = $query->fetch()) {
                    echo '<span class="record__header">Дата и время посещения</span>
                    <span class="record__description">' . $row["available_date"] . ', ' . $row["available_time"] . '</span>';
                }
                ?>
            </section>
        </div>
        <input class="step__button" type="submit" value="Записаться">
    </form>
</main>
</body>
</html>