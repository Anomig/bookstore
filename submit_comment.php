<?php
require_once("../bootstrap.php");

if (!empty($_POST)) {
    $product_id = $_POST['product_id'];
    $user_id = $_POST['user_id'];
    $comment = $_POST['comment'];

    // Voer de nodige controles uit: bijvoorbeeld controleren of het product gekocht is door de gebruiker
    $db = Db::getConnection();
    $stmt = $db->prepare("INSERT INTO comments (user_id, product_id, comment) VALUES (:user_id, :product_id, :comment)");
    $stmt->execute([
        'user_id' => $user_id,
        'product_id' => $product_id,
        'comment' => $comment
    ]);

    // Stuur een JSON-respons terug
    echo json_encode(['status' => 'success', 'message' => 'Commentaar is toegevoegd!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Er ging iets mis. Probeer het opnieuw.']);
}
?>
