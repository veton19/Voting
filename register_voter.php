<?php
include 'Database.php';
include 'Voter.php';

$db = (new Database())->connect();
$voter = new Voter($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['voter_name']);

    if ($voter->isRegistered($name)) {
        echo "<p style='color:red;'>Voter is already registered.</p>";
    } else {
        $voter->registerVoter($name);
        // Redirect to voting page
        header("Location: vote.php?voter_name=" . urlencode($name));
        exit();
    }
}
?>