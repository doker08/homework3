<?php include ROOT . '/lib/template/header.php'; ?>

    <div class="form">
        <h2>Журнал посещений врачей</h2><br><br>
        <form action="#" method="post" class="form">
            <b>Сортировка:</b><br><br>
            <select class="style1" style="height: 34px;" name="sort">
                <option value="date">По дате</option>
                <option value="doctors">По врачам</option>
                <option value="patients">По пациентам</option>
            </select>
            <input type="submit" class="button1" name="submit" value="Сортировать">
        </form>
        <br>
        <table>
            <th width="3%">#</th>
            <th width="20%">Доктор</th>
            <th width="20%">Пациент</th>
            <th width="20%">Дата</th>
            <th width="%37">Комментарий</th>
        <?php foreach ($logs as $row){
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['doctor_name']}</td>";
            echo "<td>{$row['patient_name']}</td>";
            echo "<td>{$row['date']}</td>";
            echo "<td>{$row['notice']}</td>";
            echo "</tr>";
        }
        ?>
        </table>
    </div>

<?php include ROOT . '/lib/template/footer.php'; ?>