<?php include ROOT . '/lib/template/header.php'; ?>

<?php if ($result): ?>
    <ul><li>Логин изменен!</li></ul>
<?php else: ?>
    <?php if (isset($errors) && is_array($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li> - <?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>
    <form action="#" method="post" class="form">
        <h2>Изменить имя</h2>
        <ul><br>
            <li>
                <label>Имя:</label>
                <input type="text" name="name" class="style1" placeholder="Имя" value="<?php echo $name ?>"/>
            </li>
            <li>
                <input type="submit" name="submit" class="button1" value="Сохранить" />
            </li>
        </ul>
    </form>



<?php include ROOT . '/lib/template/footer.php'; ?>