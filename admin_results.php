<?php
include 'Database.php';
include 'Admin.php';

$db = (new Database())->connect();
$admin = new Admin($db);

$voteCounts = $admin->countVotes();

?>

<h1>Admin Dashboard</h1>

<h2>Vote Counts</h2>
<table>
    <tr>
        <th>Category</th>
        <th>Nominee</th>
        <th>Votes</th>
    </tr>
    <?php foreach ($voteCounts as $vote): ?>
        <tr>
            <td><?= htmlspecialchars($vote['category']) ?></td>
            <td><?= htmlspecialchars($vote['nominee_name']) ?></td>
            <td><?= $vote['votes'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>