<?php

include 'connection.php';

if ($_POST) {

    //POST DATA
    $ni = filter_input(INPUT_POST, 'ni', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $telepon = filter_input(INPUT_POST, 'telepon', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $tanggal_register = date('d M Y');
    $response = [];

    //Cek username didalam databse
    $userQuery = $connection->prepare("SELECT * FROM tb_user where username = ?");
    $userQuery->execute(array($username));

    // Cek username apakah ada tau tidak
    if ($userQuery->rowCount() != 0) {
        // Beri Response
        $response['status'] = false;
        $response['message'] = 'Akun sudah digunakan';
    } else {
        $insertAccount = 'INSERT INTO tb_user (ni, username, nama, alamat, status, telepon, tanggal_register, password) values (:ni, :username, :nama,  :alamat, :status, :telepon, :tanggal_register, :password)';
        $statement = $connection->prepare($insertAccount);

        try {
            //Eksekusi statement db
            $statement->execute([
                ':ni' => $ni,
                ':username' => $username,
                ':nama' => $nama,
                ':alamat' => $alamat,
                ':status' => $status,
                ':telepon' => $telepon,
                ':tanggal_register' => $tanggal_register,
                ':password' => md5($password),
            ]);

            //Beri response
            $response['status'] = true;
            $response['message'] = 'Akun berhasil didaftar';
            $response['data'] = [
                'username' => $username,
                'nama' => $nama,
            ];
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    //Jadikan data JSON
    $json = json_encode($response, JSON_PRETTY_PRINT);

    //Print JSON
    echo $json;
}
