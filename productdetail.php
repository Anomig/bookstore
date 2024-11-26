<?php
session_start();
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Users.php");
include_once(__DIR__ . "/classes/Books.php");

$db = Db::getConnection();
$product_id = $_GET['id'];  // Stel dat we het product-id ophalen uit de URL

// Controleer of de gebruiker het product heeft gekocht
$user_id = $_SESSION['user_id']; // Zorg ervoor dat je het user_id opslaat bij login

// Haal de bestellingen van de gebruiker op
$stmt = $db->prepare("SELECT * FROM orders WHERE user_id = :user_id AND product_id = :product_id");
$stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
$has_purchased = $stmt->rowCount() > 0;  // Als de gebruiker het product heeft gekocht, kunnen ze reageren

// Haal bestaande commentaren en ratings op
$comments_stmt = $db->prepare("SELECT * FROM comments WHERE product_id = :product_id");
$comments_stmt->execute(['product_id' => $product_id]);
$comments = $comments_stmt->fetchAll(PDO::FETCH_ASSOC);

$ratings_stmt = $db->prepare("SELECT AVG(rating) as average_rating FROM ratings WHERE product_id = :product_id");
$ratings_stmt->execute(['product_id' => $product_id]);
$average_rating = $ratings_stmt->fetch(PDO::FETCH_ASSOC)['average_rating'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Product Details</h1>
    <!-- Toon productinformatie hier -->

    <!-- Toon de gemiddelde beoordeling -->
    <div class="average-rating">
        <p>Gemiddelde beoordeling: <?= number_format($average_rating, 1); ?> / 5</p>
    </div>

    <!-- Beoordeling sectie -->
    <?php if ($has_purchased): ?>
        <div class="rating-form">
            <label for="rating">Geef een rating (1-5):</label>
            <input type="number" id="rating" min="1" max="5" step="1">
            <button id="submit-rating">Beoordeling indienen</button>
        </div>

        <div class="comment-form">
            <label for="comment">Schrijf een commentaar:</label>
            <textarea id="comment" rows="4" cols="50"></textarea>
            <button id="submit-comment">Commentaar indienen</button>
        </div>
    <?php else: ?>
        <p>Je kunt alleen een beoordeling of commentaar plaatsen als je dit product hebt gekocht.</p>
    <?php endif; ?>

    <h2>Commentaren:</h2>
    <div id="comments">
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p><strong>Gebruiker <?= $comment['user_id']; ?> zei:</strong></p>
                <p><?= htmlspecialchars($comment['comment']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        $(document).ready(function() {
            // Commentaar indienen via AJAX
            $('#submit-comment').click(function() {
                var comment = $('#comment').val();
                $.ajax({
                    url: 'submit_comment.php',
                    type: 'POST',
                    data: {
                        product_id: <?= $product_id ?>,
                        user_id: <?= $user_id ?>,
                        comment: comment
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status === 'success') {
                            $('#comments').append('<div class="comment"><p><strong>Je zei:</strong></p><p>' + comment + '</p></div>');
                            $('#comment').val('');  // Clear comment box
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            // Rating indienen via AJAX
            $('#submit-rating').click(function() {
                var rating = $('#rating').val();
                $.ajax({
                    url: 'submit_rating.php',
                    type: 'POST',
                    data: {
                        product_id: <?= $product_id ?>,
                        user_id: <?= $user_id ?>,
                        rating: rating
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status === 'success') {
                            alert(response.message);
                            // Optioneel: update de gemiddelde beoordeling
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
