<?php include ROOT . '/lib/template/header.php'; ?>

<?php if ($result): ?>
    <ul>
        <li>Запись изменена!</li>
    </ul>
<?php endif; ?>

    <div class="form">
        <form action="#" method="post" class="form">
            <h2>Редактирование записи #<?php echo $note['id']?></h2>
            <ul>
                <li>
                    <label for="name">Доктор:</label>
                    <?php echo $_SESSION['username']; ?>
                    <input type="hidden" name="id" value="<?php echo $note['id']?>"/>
                </li>
                <li>
                    <label>Дата:</label>
                    <input type="datetime-local" name="date" class="style1" value="<?php echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($note['date'])) ?>"/>
                </li>
                <li>
                    <label>Статус:</label>
                    <select class="style1" style="height: 35px; width: 240px;" name="status">
                        <option value="Закрыт">Закрыт</option>
                        <option value="Ожидание">Ожидание</option>
                    </select>
                </li>
                <li>
                    <label>Примечение:</label>
                    <textarea name="notice" rows="7"><?php echo $note['notice'];?></textarea>
                </li>
                <li>
                    <input type="submit" name="submit" class="button1" value="Сохранить" />
                </li>
            </ul>
        </form>
    </div>

<?php include ROOT . '/lib/template/footer.php'; ?>