<?php include ROOT . '/lib/template/header.php'; ?>

        <form action="#" method="post" class="form">
            <h2>Запись на прием</h2>
            <?php if (isset($errors) && is_array($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if ($result): ?>
                <ul>
                    <li>Запись добавлена!</li>
                </ul>
            <?php endif; ?>
            <ul>
                <li>
                    <label for="name">Доктор:</label>
                    <?php echo $doctor['name'] ?>
                    <input type="hidden" name="doctor_id" value="<?php echo $doctor['id'] ?>"/>
                    <input type="hidden" name="patient_id" value="<?php echo $_SESSION['user'] ?>"/>
                </li>
                <li>
                    <label>Дата:</label>
                    <input type="datetime-local" name="date" class="style1" value=""/>
                </li>
                <li>
                    <input type="submit" name="submit" class="button1" value="Отправить" />
                </li>
            </ul>
        </form>

<?php include ROOT . '/lib/template/footer.php'; ?>