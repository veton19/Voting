<?php
include 'db.php';

// Fetch winners for each category
$categories = ['Makes Work Fun', 'Team Player', 'Culture Champion', 'Difference Maker'];
$results = [];

foreach ($categories as $category) {
    $stmt = $pdo->prepare("SELECT nominee_name, COUNT(*) AS votes FROM votes WHERE category = ? GROUP BY nominee_name ORDER BY votes DESC LIMIT 1");
    $stmt->execute([$category]);
    $results[$category] = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (count($topNominees) > 1 && $topNominees[0]['votes'] == $topNominees[1]['votes']) {
    // Tie detected
    $results[$category] = ['nominee_name' => null, 'votes' => null, 'is_tie' => true];
} else {
    // No tie
    $results[$category] = ['nominee_name' => $topNominees[0]['nominee_name'] ?? 'No votes yet', 'votes' => $topNominees[0]['votes'] ?? 0, 'is_tie' => false];
}


// Fetch most active voters
$activeVoters = $pdo->query("SELECT voter_name, COUNT(*) AS votes_cast FROM votes GROUP BY voter_name ORDER BY votes_cast DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Voting Results</title>
</head>
<body>
    <h1>Voting Results</h1>

    <h2>Category Winners</h2>
    <ul>
        <?php foreach ($results as $category => $winner): ?>
            <li>
                <strong><?= htmlspecialchars($category) ?>:</strong> 
                <?php if ($winner['is_tie']): ?>
                    <em>Invalid (tie detected)</em>
                <?php else: ?>
                    <?= htmlspecialchars($winner['nominee_name'] ?? 'No votes yet') ?> (<?= $winner['votes'] ?? 0 ?> votes)
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Most Active Voters</h2>
    <ul>
        <?php foreach ($activeVoters as $voter): ?>
            <li><?= htmlspecialchars($voter['voter_name']) ?> (<?= $voter['votes_cast'] ?> votes)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>