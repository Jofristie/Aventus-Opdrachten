<?php
require_once __DIR__ . '/../includes/db.php';

/**
 * Project-klasse
 * Eigenschappen: title, description, date, category
 * FreelanceProject en SchoolProject erven hiervan over met extra eigenschappen.
 */

class Project
{
    protected ?int $id = null;
    protected int $userId;
    protected string $title;
    protected string $description;
    protected string $date;
    protected string $category;
    protected string $image;

    public function __construct(
        int $userId = 0,
        string $title = '',
        string $description = '',
        string $date = '',
        string $category = 'school',
        string $image = ''
    ) {
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->category = $category;
        $this->image = $image;
    }

    // ---------- Getters ----------
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getImage(): string
    {
        return $this->image !== '' ? $this->image : 'assets/img/default-project.png';
    }

    // ---------- Setters ----------
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = trim($title);
    }

    public function setDescription(string $description): void
    {
        $this->description = trim($description);
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * Geeft extra informatie terug die specifiek is voor een subklasse.
     * Wordt overschreven door FreelanceProject en SchoolProject.
     */
    public function getExtraInfo(): array
    {
        return [];
    }

    // ---------- Database (CRUD) ----------

    /**
     * Voegt dit project toe aan de database.
     */
    public function save(): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'INSERT INTO projects (user_id, title, description, category, date, image, client_name, budget, school_name, grade)
             VALUES (:user_id, :title, :description, :category, :date, :image, :client_name, :budget, :school_name, :grade)'
        );

        $extra = $this->getExtraInfo();

        return $stmt->execute([
            'user_id' => $this->userId,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'date' => $this->date,
            'image' => $this->image,
            'client_name' => $extra['client_name'] ?? null,
            'budget' => $extra['budget'] ?? null,
            'school_name' => $extra['school_name'] ?? null,
            'grade' => $extra['grade'] ?? null,
        ]);
    }

    /**
     * Werkt een bestaand project bij.
     */
    public function update(): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'UPDATE projects SET title = :title, description = :description, category = :category,
             date = :date, image = :image, client_name = :client_name, budget = :budget,
             school_name = :school_name, grade = :grade WHERE id = :id AND user_id = :user_id'
        );

        $extra = $this->getExtraInfo();

        return $stmt->execute([
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'date' => $this->date,
            'image' => $this->image,
            'client_name' => $extra['client_name'] ?? null,
            'budget' => $extra['budget'] ?? null,
            'school_name' => $extra['school_name'] ?? null,
            'grade' => $extra['grade'] ?? null,
            'id' => $this->id,
            'user_id' => $this->userId,
        ]);
    }

    /**
     * Verwijdert een project op basis van id (alleen door de eigenaar).
     */
    public static function delete(int $id, int $userId): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM projects WHERE id = :id AND user_id = :user_id');

        return $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }

    /**
     * Haalt alle projecten op, eventueel gefilterd op categorie.
     */
    public static function findAll(?string $category = null): array
    {
        $db = Database::getConnection();

        if ($category && $category !== 'all') {
            $stmt = $db->prepare('SELECT * FROM projects WHERE category = :category ORDER BY date DESC');
            $stmt->execute(['category' => $category]);
        } else {
            $stmt = $db->query('SELECT * FROM projects ORDER BY date DESC');
        }

        $rows = $stmt->fetchAll();

        return array_map([self::class, 'fromRow'], $rows);
    }

    /**
     * Haalt alle projecten van één specifieke gebruiker op.
     */
    public static function findByUser(int $userId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM projects WHERE user_id = :user_id ORDER BY date DESC');
        $stmt->execute(['user_id' => $userId]);

        return array_map([self::class, 'fromRow'], $stmt->fetchAll());
    }

    /**
     * Haalt één project op basis van id op.
     */
    public static function findById(int $id): ?Project
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM projects WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? self::fromRow($row) : null;
    }

    /**
     * Factory-methode: bouwt automatisch het juiste (sub)klasse-object
     * op basis van de categorie in de databaserij.
     */
    protected static function fromRow(array $row): Project
    {
        switch ($row['category']) {
            case 'freelance':
                $project = new FreelanceProject(
                    (int) $row['user_id'],
                    $row['title'],
                    $row['description'],
                    $row['date'],
                    $row['image'] ?? '',
                    $row['client_name'] ?? '',
                    (float) ($row['budget'] ?? 0)
                );
                break;

            case 'school':
                $project = new SchoolProject(
                    (int) $row['user_id'],
                    $row['title'],
                    $row['description'],
                    $row['date'],
                    $row['image'] ?? '',
                    $row['school_name'] ?? '',
                    $row['grade'] ?? ''
                );
                break;

            default:
                $project = new Project(
                    (int) $row['user_id'],
                    $row['title'],
                    $row['description'],
                    $row['date'],
                    $row['category'],
                    $row['image'] ?? ''
                );
        }

        $project->setId((int) $row['id']);

        return $project;
    }
}
