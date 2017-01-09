<?php include ROOT . '/lib/template/header.php'; ?>

<?php if ($result): ?>
    <ul>
        <li>Вы зарегистрированы! На вашу почту было отправлено сообщение с ссылкой на активацию.</li>
    </ul>
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
                            <h2>Регистрация на сайте</h2>
                            <ul>
                                <li>
                                    <label>ФИО:</label>
                                    <input type="text" name="name" class="style1" placeholder="Логин" value=""/>
                                </li>
                                <li>
                                    <label for="name">Почта:</label>
                                    <input type="email" name="email" class="style1" placeholder="E-mail" value=""/>
                                </li>
                                <li>
                                    <label>Пароль:</label>
                                    <input type="password" name="password" class="style1" placeholder="Пароль" value=""/>
                                </li>
                                <li>
                                    <label>Повторите пароль:</label>
                                    <input type="password" name="password2" class="style1" placeholder="Пароль" value=""/>
                                </li>
                                <li>
                                    <input type="submit" name="submit" class="button1" value="Регистрация" />
                                </li>
                            </ul>
                        </form>

<?php include ROOT . '/lib/template/footer.php'; ?>