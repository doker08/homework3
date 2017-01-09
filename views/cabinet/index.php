<?php include ROOT . '/lib/template/header.php'; ?>

    <div class="form">
        <h2>Привет, <?php echo $user['name'];?>!</h2>
        <ul>
            <li><a href="/cabinet/edit/name">Изменить имя</a></li>
            <li><a href="/cabinet/edit/password">Изменить пароль</a></li>
            <li><a href="/cabinet/edit/email">Изменить почту</a></li>
        </ul>
    </div>

<?php include ROOT . '/lib/template/footer.php'; ?>