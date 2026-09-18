<?php
require_once __DIR__ . '/UserProfile.php';
require_once __DIR__ . '/../includes/db.php';

/**
 * User-klasse
 * Eigenschappen: username, email, role
 * Heeft een gekoppelde UserProfile voor bio/profileImage/website.
 */

class User
{
    private ?int $id = null;
    private string $username;
    private string $email;
    private string $role;
    private ?UserProfile $profile = null;

    public function __construct(string $username = '', string $email = '', string $role = 'student')
    {
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
        $this->profile = new UserProfile();
    }

    // ---------- Getters ----------
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getProfile(): UserProfile
    {
        return $this->profile;
    }

    // ---------- Setters ----------
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUsername(string $username): void
    {
        $this->username = trim($username);
    }

    public function setEmail(string $email): void
    {
        $this->email = trim($email);
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setProfile(UserProfile $profile): void
    {
        $this->profile = $profile;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // ---------- Statische/database methodes ----------

    /**
     * Registreert een nieuwe gebruiker in de database.
     */
    public static function register(string $username, string $email, string $password, string $role = 'student'): bool
    {
        $db = Database::getConnection();

        $stmt = $db->prepare('SELECT id FROM users WHERE username = :username OR email = :email');
        $stmt->execute(['username' => $username, 'email' => $email]);
        if ($stmt->fetch()) {
            return false; // gebruiker of e-mail bestaat al
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare(
            'INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)'
        );

        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => $role,
        ]);
    }

    /**
     * Logt een gebruiker in en geeft bij succes een User-object terug.
     */
    public static function login(string $email, string $password): ?User
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['password'])) {
            return self::fromRow($row);
        }

        return null;
    }

    /**
     * Haalt een gebruiker op basis van id op.
     */
    public static function findById(int $id): ?User
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? self::fromRow($row) : null;
    }

    /**
     * Slaat de profielgegevens (bio, profileImage, website) op in de database.
     */
    public function saveProfile(): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'UPDATE users SET bio = :bio, profileImage = :profileImage, website = :website WHERE id = :id'
        );

        return $stmt->execute([
            'bio' => $this->profile->getBio(),
            'profileImage' => $this->profile->getProfileImage(),
            'website' => $this->profile->getWebsite(),
            'id' => $this->id,
        ]);
    }

    /**
     * Bouwt een User-object op basis van een databaserij.
     */
    private static function fromRow(array $row): User
    {
        $user = new User($row['username'], $row['email'], $row['role']);
        $user->setId((int) $row['id']);

        $profile = new UserProfile(
            $row['bio'] ?? '',
            $row['profileImage'] ?? '',
            $row['website'] ?? ''
        );
        $user->setProfile($profile);

        return $user;
    }
}
