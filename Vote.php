<?php
include 'Database.php';
include 'Vote.php';
include 'submit_vote.php';

$db = (new Database())->connect();
$vote = new Vote($db);

$voter_name = $_GET['voter_name'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nominee_name = trim($_POST['nominee_name']);
    $category = $_POST['category'];
    $comment = trim($_POST['comment']);

    if ($voter_name === $nominee_name) {
        die("You cannot vote for yourself.");
    }

    if ($vote->submitVote($voter_name, $nominee_name, $category, $comment)) {
        echo "<p style='color:green;'>Vote submitted successfully!</p>";
    } else {
        echo "<p style='color:red;'>Failed to submit your vote. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote</title>
</head>
<body>
    <h1>Vote for Your Nominee</h1>
    <form action="vote.php?voter_name=<?= urlencode($voter_name) ?>" method="POST">
        <input type="hidden" name="voter_name" value="<?= htmlspecialchars($voter_name) ?>">
        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <option value="Makes Work Fun">Makes Work Fun</option>
            <option value="Team Player">Team Player</option>
            <option value="Culture Champion">Culture Champion</option>
            <option value="Difference Maker">Difference Maker</option>
        </select>
        <br>
        <label for="nominee_name">Nominee Name:</label>
        <input type="text" id="nominee_name" name="nominee_name" required>
        <br>
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment"></textarea>
        <br>
        <button type="submit">Submit Vote</button>
    </form>
</body>
</html>