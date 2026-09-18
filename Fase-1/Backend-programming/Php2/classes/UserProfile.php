<?php
/**
 * UserProfile-klasse
 * Bevat de profielgegevens van een gebruiker: bio, profielafbeelding en website.
 */

class UserProfile
{
    private string $bio;
    private string $profileImage;
    private string $website;

    public function __construct(string $bio = '', string $profileImage = '', string $website = '')
    {
        $this->bio = $bio;
        $this->profileImage = $profileImage;
        $this->website = $website;
    }

    // ---------- Getters ----------
    public function getBio(): string
    {
        return $this->bio;
    }

    public function getProfileImage(): string
    {
        return $this->profileImage !== '' ? $this->profileImage : 'assets/img/default-profile.png';
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    // ---------- Setters ----------
    public function setBio(string $bio): void
    {
        $this->bio = trim($bio);
    }

    public function setProfileImage(string $profileImage): void
    {
        $this->profileImage = $profileImage;
    }

    public function setWebsite(string $website): void
    {
        $this->website = trim($website);
    }
}
