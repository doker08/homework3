<?php include ROOT . '/lib/template/header.php'; ?>

    <div class="form">
        <h2>Записаться к врачу</h2><br><br>
        <table width="100%">
            <thead>
            <th width="50%">Доктор</th>
            <th width="30%">Должность</th>
            <th width="20%">Записаться</th>
            </thead>
            <?php foreach ($doctors as $doctor) {
                echo "<tr>";
                echo "<td>{$doctor['name']}</td>";
                echo "<td>{$doctor['post']}</td>";
                echo "<td><a href='/patient/addvisiting/{$doctor['id']}'>Запись</a> ";
                echo "</tr>";
            }?>
        </table>
    </div>

<?php include ROOT . '/lib/template/footer.php'; ?>