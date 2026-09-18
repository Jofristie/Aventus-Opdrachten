<?php
require_once __DIR__ . '/Project.php';

/**
 * FreelanceProject
 * Subklasse van Project met extra eigenschappen voor freelance-opdrachten.
 */

class FreelanceProject extends Project
{
    private string $clientName;
    private float $budget;

    public function __construct(
        int $userId = 0,
        string $title = '',
        string $description = '',
        string $date = '',
        string $image = '',
        string $clientName = '',
        float $budget = 0.0
    ) {
        parent::__construct($userId, $title, $description, $date, 'freelance', $image);
        $this->clientName = $clientName;
        $this->budget = $budget;
    }

    public function getClientName(): string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): void
    {
        $this->clientName = $clientName;
    }

    public function getBudget(): float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): void
    {
        $this->budget = $budget;
    }

    /**
     * Overschrijft de parent-methode om freelance-specifieke info te tonen.
     */
    public function getExtraInfo(): array
    {
        return [
            'client_name' => $this->clientName,
            'budget' => $this->budget,
        ];
    }
}
