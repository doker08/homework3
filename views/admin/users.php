<?php include ROOT . '/lib/template/header.php'; ?>

    <div class="form">
        <h2>Управление пользователями</h2>

        <br><br><table>
                <th width="3%">#</th>
                <th width="20%">ФИО</th>
                <th width="20%">Статус</th>
                <?php foreach ($users as $user){
                    echo "<tr>";
                    echo "<td>{$user['id']}</a>";
                    echo "<td><a href='/admin/user/{$user['id']}'>{$user['name']}</a></td>";
                    echo "<td>{$user['user_type']}</td>";
                    //echo "<td>{$user['patient_name']}</td>";
                    echo "</tr>";
                }
                ?>
            </table>
    </div>

<?php include ROOT . '/lib/template/footer.php'; ?>