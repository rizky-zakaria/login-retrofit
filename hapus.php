<?php

include 'connection.php';

$id_user = $_POST['id_user'];

$userQuery = $connection->prepare("DELETE FROM tb_user WHERE id_user = $id_user");
$result = $userQuery->execute();

if ($result) {
    # code...
}
