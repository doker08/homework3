<?php include ROOT . '/lib/template/header.php'; ?>

    <div class="form">
        <h2>Расписание</h2><br><br>
        <form action="#" method="post" class="form">
            <b>Сортировка:</b><br><br>
            <select class="style1" style="height: 34px;" name="sort">
                <option value="date">По дате</option>
                <option value="doctors">По врачам</option>
            </select>
            <input type="submit" class="button1" name="submit" value="Сортировать">
        </form>
        <br>
        <table width="100%">
            <thead>
            <th width="50%">Доктор</th>
            <th width="20%">Время</th>
            <th width="30%">Примечание</th>
            </thead>
            <?php foreach ($doctors as $doctor) {
                echo "<tr>";
                echo "<td>{$doctor['name']}</td>";
                echo "<td>{$doctor['date']}</td>";
                echo "<td>{$doctor['notice']}</td>";
                echo "</tr>";
            }?>
        </table>
    </div>

<?php include ROOT . '/lib/template/footer.php'; ?>