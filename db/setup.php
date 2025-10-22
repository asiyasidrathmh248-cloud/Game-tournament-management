<?php
function setup_database() {
    try {
        $pdo = db();
        // Turn on errors
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Organisers Table
        $pdo->exec("CREATE TABLE IF NOT EXISTS organisers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");

        // Venues Table
        $pdo->exec("CREATE TABLE IF NOT EXISTS venues (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            location TEXT,
            capacity INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");

        // Games Table
        $pdo->exec("CREATE TABLE IF NOT EXISTS games (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            game_date DATETIME NOT NULL,
            venue_id INT,
            organiser_id INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE SET NULL,
            FOREIGN KEY (organiser_id) REFERENCES organisers(id) ON DELETE CASCADE
        ) ENGINE=INNODB;");

        // Players Table
        $pdo->exec("CREATE TABLE IF NOT EXISTS players (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");

        // Registrations Table
        $pdo->exec("CREATE TABLE IF NOT EXISTS registrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            player_id INT NOT NULL,
            game_id INT NOT NULL,
            registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status VARCHAR(50) DEFAULT 'confirmed', -- confirmed, cancelled
            FOREIGN KEY (player_id) REFERENCES players(id) ON DELETE CASCADE,
            FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
            UNIQUE(player_id, game_id)
        ) ENGINE=INNODB;");

        // Winners Table
        $pdo->exec("CREATE TABLE IF NOT EXISTS winners (
            id INT AUTO_INCREMENT PRIMARY KEY,
            game_id INT NOT NULL,
            player_id INT NOT NULL,
            prize VARCHAR(255),
            announced_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
            FOREIGN KEY (player_id) REFERENCES players(id) ON DELETE CASCADE,
            UNIQUE(game_id) -- Only one winner per game
        ) ENGINE=INNODB;");

        // Seed data if tables are empty
        $stmt = $pdo->query("SELECT COUNT(*) FROM games");
        if ($stmt->fetchColumn() == 0) {
            // Seed venues
            $pdo->exec("INSERT INTO venues (name, location, capacity) VALUES ('Main Arena', '123 Gaming St, Metropolia', 1000), ('Community Hall', '456 Sidequest Ave, Townsville', 150);");
            $venue1_id = $pdo->lastInsertId();
            $venue2_id = $pdo->lastInsertId() -1;


            // Seed organisers
            $pdo->exec("INSERT INTO organisers (name, email, password) VALUES ('Tournament Master', 'admin@tourney.com', '".password_hash('password', PASSWORD_DEFAULT)."');");
            $organiser_id = $pdo->lastInsertId();

            // Seed games
            $pdo->exec("INSERT INTO games (name, description, game_date, venue_id, organiser_id) VALUES
                ('Cyberclash 2025', 'The ultimate esports showdown. Featuring top players from around the globe.', '2025-11-15 10:00:00', $venue2_id, $organiser_id),
                ('Pixel Masters Cup', 'A celebration of retro gaming and modern indies.', '2025-12-01 12:00:00', $venue1_id, $organiser_id),
                ('Strategy Summit', 'For the grandmasters of turn-based and real-time strategy.', '2026-01-20 09:00:00', $venue2_id, $organiser_id);");
        }

        return ['success' => true];
    } catch (PDOException $e) {
        // In a real app, log this error instead of echoing
        return ['success' => false, 'error' => $e->getMessage()];
    }
}
?>