<?php include ROOT . '/lib/template/header.php'; ?>

    <div class="form">
        <h2>Кабинет доктора</h2><br><br>
        <table>
            <thead>
                <th width="35%">Пациент</th>
                <th width="20%">Дата</th>
                <th width="10%">Статус</th>
                <th width="25%">Примечание</th>
                <th width="10%">Изменить</th>
            </thead>
        <?php foreach ($visits as $visit) {
            echo "<tr>";
            //echo "<td><a href='/user/{$patient['patient_id']}'>{$patient['patient_name']}</a></td>";
            echo "<td>{$visit['patient_name']}</td>";
            echo "<td>{$visit['date']}</td>";
            echo "<td>{$visit['status']}</td>";
            echo "<td>{$visit['notice']}</td>";
            echo "<td><a href='/doctor/note/edit/{$visit['id']}'><img src='/lib/images/edit.png'></a> ";
            echo "<a href='/doctor/note/delete/{$visit['id']}'><img src='/lib/images/delete.png'></a></td>";
            echo "</tr>";
        }?>
        </table>
    </div>

<?php include ROOT . '/lib/template/footer.php'; ?>