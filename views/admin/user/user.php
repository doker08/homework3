<?php include ROOT . '/lib/template/header.php'; ?>

    <div class="form">
        <h2>Пользователь <?php echo $user['name'];?></h2>
            <?php if($user['status'] == "OK"){ ?>
                <font color="green">Статус: Активен</font>
            <?php }else {?>
                <font color="red">Статус: Заблокирован</font>
            <?php } ?>
            <ul>
                <li><a href="/admin/user/editname/<?php echo $user['id'] ?>">Изменить имя</a></li>
                <li><a href="/admin/user/editmail/<?php echo $user['id'] ?>">Изменить почту</a></li>
                <?php if($user['status'] == "OK"){ ?>
                    <li><a href="/admin/user/block/<?php echo $user['id']?>"><font color="red">Заблокировать</font></a></li>
                <?php }else {?>
                    <li><a href="/admin/user/unblock/<?php echo $user['id']?>"><font color="green">Разблокировать</font></a></li>
                <?php } ?>

            </ul>
    </div>

<?php include ROOT . '/lib/template/footer.php'; ?>