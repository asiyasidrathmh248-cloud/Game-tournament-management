<?php
require_once 'db/config.php';
require_once 'db/setup.php';

// Run setup to ensure tables and data exist
$setup_result = setup_database();

// Fetch games from the database
$games = [];
$error_message = '';

if ($setup_result['success']) {
    try {
        $pdo = db();
        $stmt = $pdo->prepare(
            "SELECT g.id, g.name, g.description, g.game_date, v.name as venue_name
             FROM games g
             LEFT JOIN venues v ON g.venue_id = v.id
             ORDER BY g.game_date ASC"
        );
        $stmt->execute();
        $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_message = "Error fetching tournaments: " . $e->getMessage();
    }
} else {
    $error_message = "Database setup failed: " . ($setup_result['error'] ?? 'Unknown error');
}

include 'header.php';
?>

<div class="container">
    <div class="text-center mb-5">
        <h1 class="display-4">Upcoming Tournaments</h1>
        <p class="lead text-muted">Join the thrill of competition. Find your next challenge below.</p>
    </div>

    <?php if ($error_message): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php elseif (empty($games)): ?>
        <div class="alert alert-info text-center">
            <h2>Stay Tuned!</h2>
            <p>No upcoming tournaments at the moment. Please check back soon!</p>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($games as $game): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($game['name']); ?></h5>
                            <p class="card-text text-muted flex-grow-1"><?php echo htmlspecialchars($game['description']); ?></p>
                            <ul class="list-unstyled text-muted mb-4">
                                <li><i class="bi bi-calendar-event text-primary"></i> <?php echo date('F j, Y @ g:i A', strtotime($game['game_date'])); ?></li>
                                <li><i class="bi bi-geo-alt-fill text-primary"></i> <?php echo htmlspecialchars($game['venue_name'] ?? 'TBA'); ?></li>
                            </ul>
                            <a href="#" class="btn btn-primary mt-auto">Register Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>