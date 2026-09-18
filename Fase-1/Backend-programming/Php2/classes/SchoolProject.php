<?php
require_once __DIR__ . '/Project.php';

/**
 * SchoolProject
 * Subklasse van Project met extra eigenschappen voor schoolopdrachten.
 */

class SchoolProject extends Project
{
    private string $schoolName;
    private string $grade;

    public function __construct(
        int $userId = 0,
        string $title = '',
        string $description = '',
        string $date = '',
        string $image = '',
        string $schoolName = '',
        string $grade = ''
    ) {
        parent::__construct($userId, $title, $description, $date, 'school', $image);
        $this->schoolName = $schoolName;
        $this->grade = $grade;
    }

    public function getSchoolName(): string
    {
        return $this->schoolName;
    }

    public function setSchoolName(string $schoolName): void
    {
        $this->schoolName = $schoolName;
    }

    public function getGrade(): string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): void
    {
        $this->grade = $grade;
    }

    /**
     * Overschrijft de parent-methode om school-specifieke info te tonen.
     */
    public function getExtraInfo(): array
    {
        return [
            'school_name' => $this->schoolName,
            'grade' => $this->grade,
        ];
    }
}
