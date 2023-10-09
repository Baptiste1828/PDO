<?php

require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstName']); 
    $lastname = trim($_POST['lastName']);

    if (!empty($firstname) && !empty($lastname) && strlen($firstname) < 45 && strlen($lastname) < 45) {
        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $pdo->prepare($query);

        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

        $statement->execute();
        header("Location: index.php");
        die();
    }
}

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PDO</title>
    </head>

    <body>
        <ul>
            <?php foreach($friends as $friend) :?>
                <li><?=$friend['firstname'] . ' ' . $friend['lastname'];?></li>
            <?php endforeach; ?>
        </ul>
        <form action="index.php" method="post">
            <label for="firstName">Votre prénom :</label>
            <input type="text" id="firstName" name="firstName" required>
            <label for="lastName">Votre nom :</label>
            <input type="text" id="lastName" name="lastName" required>
            <button type="submit">Envoyer</button>
    </body>
</html>