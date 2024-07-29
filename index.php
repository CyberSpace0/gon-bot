<?php
require __DIR__.'/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'e4fdbb3c7ceb2ea3803a4947003131de';


#----------------------------------

$user = 'root';
$pass = '123123';


$pdo = new PDO('mysql:host=localhost;dbname=gon', $user, $pass);

$data = $_GET['key'];
$key = htmlspecialchars($data);
$stmt = $pdo->prepare("SELECT * FROM seriel where seriel = ?");
$stmt->execute([$key]);
$user = $stmt->fetch();
$status = $user['valid'];
$seriel = $user['seriel'];
$user_agent = $user['user_agent'];


$mac = $_GET['mac'];
if($seriel == ''){
    echo 'False';
}
else{
    if($status == 'True'){
        if($user_agent == $mac){
            $payload = [
                'valid' => true,
                'seriel' => $seriel
            ];
            $jwt1 = JWT::encode($payload,$key,'HS256');
            echo $jwt1;
        }
        else{
        echo 'This key is used';
        }
    }
    else{
    $payload = [
        'valid' => true,
        'seriel' => $seriel
    ];
    $jwt = JWT::encode($payload,$key,'HS256');
    echo $jwt;
    $update = $pdo->prepare("update seriel set valid='True',user_agent=? where seriel=?");
    $update->execute([$mac,$seriel]);

    }

}

?>