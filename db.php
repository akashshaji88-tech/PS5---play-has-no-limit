<?php
/**
 * PS5 ADVERTISING PAGE — db.php
 * Handles MySQL connection via PDO and performs auto-initialization of the database and tables.
 */

$host = '127.0.0.1';
$port = '3307'; // XAMPP MySQL is configured to run on port 3307
$user = 'root';
$pass = ''; // Default XAMPP password is empty
$charset = 'utf8mb4';

// Setup connection options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // 1. First connect to server without selecting database to ensure database exists
    $dsn = "mysql:host=$host;port=$port;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `ps5_store` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    // 2. Reconnect to the newly created/existing database
    $dsn = "mysql:host=$host;port=$port;dbname=ps5_store;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // 3. Create Games Table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS `games` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(100) NOT NULL UNIQUE,
        `category` VARCHAR(50) NOT NULL,
        `genre` VARCHAR(100) NOT NULL,
        `price` DECIMAL(10, 2) NOT NULL,
        `rating` DECIMAL(2, 1) NOT NULL,
        `description` TEXT NOT NULL,
        `release_date` DATE,
        `developer` VARCHAR(100),
        `poster_path` VARCHAR(255) NOT NULL,
        `video_path` VARCHAR(255) NOT NULL,
        `is_exclusive` TINYINT(1) DEFAULT 0
    ) ENGINE=InnoDB;");
    
    // 4. Create Orders Table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS `orders` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `transaction_id` VARCHAR(50) NOT NULL UNIQUE,
        `game_id` INT NOT NULL,
        `edition` VARCHAR(50) NOT NULL,
        `customer_name` VARCHAR(100) NOT NULL,
        `customer_email` VARCHAR(100) NOT NULL,
        `customer_address` TEXT NOT NULL,
        `total_price` DECIMAL(10, 2) NOT NULL,
        `order_status` VARCHAR(50) DEFAULT 'Pending',
        `order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`game_id`) REFERENCES `games`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB;");
    
    // 5. Seed Games Table if it's empty
    $count = $pdo->query("SELECT COUNT(*) FROM `games`")->fetchColumn();
    if ($count == 0) {
        $seedGames = [
            [
                'title' => 'God of War: Ragnarök',
                'category' => 'exclusive',
                'genre' => 'Action RPG · Adventure',
                'price' => 69.99,
                'rating' => 9.8,
                'description' => 'Fimbulwinter is well underway. Kratos and Atreus must journey to each of the Nine Realms in search of answers as Asgardian forces prepare for a prophesied battle that will end the world. Along the way, they will explore stunning mythical landscapes, and face fearsome enemies in the form of Norse gods and monsters.',
                'release_date' => '2022-11-09',
                'developer' => 'Santa Monica Studio',
                'poster_path' => 'images/godofwar.jpg',
                'video_path' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4',
                'is_exclusive' => 1
            ],
            [
                'title' => "Marvel's Spider-Man 2",
                'category' => 'action',
                'genre' => 'Action · Open World',
                'price' => 69.99,
                'rating' => 9.5,
                'description' => 'Spider-Men Peter Parker and Miles Morales return for an exciting new adventure in the critically acclaimed franchise. Swing, jump and utilize the new Web Wings to travel across Marvel\'s New York, quickly switching between Peter and Miles to experience different stories and epic new powers, as the iconic villain Venom threatens to destroy their lives.',
                'release_date' => '2023-10-20',
                'developer' => 'Insomniac Games',
                'poster_path' => 'images/spiderman2.jpg',
                'video_path' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4',
                'is_exclusive' => 1
            ],
            [
                'title' => 'Final Fantasy XVI',
                'category' => 'rpg',
                'genre' => 'Action RPG · Fantasy',
                'price' => 59.99,
                'rating' => 9.0,
                'description' => 'An epic dark fantasy world where the fate of the land is decided by the mighty Eikons and the Dominants who wield them. This is the story of Clive Rosfield, a warrior granted the title "First Shield of Rosaria" and sworn to protect his younger brother Joshua, the dominant of the Phoenix. Before long, Clive will be caught up in a great tragedy and swear revenge on the Dark Eikon Ifrit.',
                'release_date' => '2023-06-22',
                'developer' => 'Creative Business Unit III (Square Enix)',
                'poster_path' => 'images/finalfantasy16.jpg',
                'video_path' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4',
                'is_exclusive' => 1
            ],
            [
                'title' => 'Gran Turismo 7',
                'category' => 'racing',
                'genre' => 'Racing Simulator',
                'price' => 59.99,
                'rating' => 8.9,
                'description' => 'Gran Turismo 7 brings together the very best features of the Real Driving Simulator. Whether you\'re a competitive or casual racer, collector, tuner, livery designer or photographer – find your line with an astronomical collection of game modes including fan-favorites like GT Campaign, Arcade and Driving School.',
                'release_date' => '2022-03-04',
                'developer' => 'Polyphony Digital',
                'poster_path' => 'images/granturismo7.jpg',
                'video_path' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/WeAreGoingOnBullrun.mp4',
                'is_exclusive' => 1
            ],
            [
                'title' => 'Ratchet & Clank: Rift Apart',
                'category' => 'exclusive',
                'genre' => 'Action · Adventure · Platformer',
                'price' => 49.99,
                'rating' => 9.2,
                'description' => 'Go dimension-hopping with Ratchet and Clank as they take on an evil emperor from another reality. Jump between action-packed worlds and beyond at mind-blowing speeds – complete with dazzling visuals and an insane arsenal – as the intergalactic adventurers blast onto the PS5 console.',
                'release_date' => '2021-06-11',
                'developer' => 'Insomniac Games',
                'poster_path' => 'images/ratchetclank.jpg',
                'video_path' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4',
                'is_exclusive' => 1
            ],
            [
                'title' => 'Returnal',
                'category' => 'action',
                'genre' => 'Roguelike · Third-Person Shooter',
                'price' => 49.99,
                'rating' => 8.8,
                'description' => 'After crash-landing on this shape-shifting world, Selene must search through the barren landscape of an ancient civilization for her escape. Isolated and alone, she finds herself fighting tooth and nail for survival. Again and again, she is defeated – forced to restart her journey every time she dies.',
                'release_date' => '2021-04-30',
                'developer' => 'Housemarque',
                'poster_path' => 'images/returnal.jpg',
                'video_path' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4',
                'is_exclusive' => 0
            ],
            [
                'title' => 'Horizon Forbidden West',
                'category' => 'rpg',
                'genre' => 'Action RPG · Open World',
                'price' => 49.99,
                'rating' => 9.2,
                'description' => 'Join Aloy as she braves the Forbidden West – a majestic but dangerous frontier that conceals mysterious new threats. Explore distant lands, fight bigger and more awe-inspiring machines, and encounter astonishing new tribes as you return to the far-future, post-apocalyptic world of Horizon.',
                'release_date' => '2022-02-18',
                'developer' => 'Guerrilla Games',
                'poster_path' => 'images/horizon.jpg',
                'video_path' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
                'is_exclusive' => 0
            ],
            [
                'title' => "Demon's Souls",
                'category' => 'exclusive',
                'genre' => 'Action RPG · Dark Fantasy',
                'price' => 69.99,
                'rating' => 8.8,
                'description' => 'Rebuilt from the ground up, this remake invites you to experience the unsettling story and ruthless combat of Demon\'s Souls in stunning visual quality. In his quest for power, the 12th King of Boletaria, King Allant channeled the ancient Soul Arts, awakening a beast from the dawn of time itself, The Old One.',
                'release_date' => '2020-11-12',
                'developer' => 'Bluepoint Games',
                'poster_path' => 'images/demonsouls.jpg',
                'video_path' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4',
                'is_exclusive' => 1
            ]
        ];
        
        $stmt = $pdo->prepare("INSERT INTO `games` 
            (`title`, `category`, `genre`, `price`, `rating`, `description`, `release_date`, `developer`, `poster_path`, `video_path`, `is_exclusive`) 
            VALUES (:title, :category, :genre, :price, :rating, :description, :release_date, :developer, :poster_path, :video_path, :is_exclusive)");
            
        foreach ($seedGames as $game) {
            $stmt->execute($game);
        }
    }
} catch (PDOException $e) {
    // If database connection fails, throw a friendly error or handle gracefully
    die("Database Connection Error: " . $e->getMessage());
}
