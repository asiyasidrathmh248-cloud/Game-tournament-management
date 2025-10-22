<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tournament Management</title>
    <meta name="description" content="A system to manage game tournaments, players, and venues. Built with Flatlogic Generator.">
    <meta name="keywords" content="game tournament, esports management, player registration, tournament bracket, venue management, game results, winner announcement, organiser tools, Built with Flatlogic Generator">
    <meta property="og:title" content="Game Tournament Management">
    <meta property="og:description" content="A system to manage game tournaments, players, and venues. Built with Flatlogic Generator.">
    <meta property="og:image" content="<?php echo htmlspecialchars($_SERVER['PROJECT_IMAGE_URL'] ?? ''); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($_SERVER['PROJECT_IMAGE_URL'] ?? ''); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/custom.css?v=<?php echo time(); ?>">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark" style="background-image: linear-gradient(45deg, #0D6EFD, #6F42C1);">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-trophy-fill"></i>
            GameTourney
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="games.php">Tournaments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Login</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link btn btn-outline-light" href="#">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-5">