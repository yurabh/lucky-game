<?php

declare(strict_types=1);

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function create(string $username, string $phone): string
    {
        $link = bin2hex(random_bytes(16));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

        $statement = $this->db->prepare("INSERT INTO users (username, phone, link, expires_at) VALUES (?, ?, ?, ?)");
        $statement->execute([$username, $phone, $link, $expiresAt]);

        return $link;
    }

    public function validateLink(?string $link): array|false
    {
        if (!$link) {
            return false;
        }

        $statement = $this->db->prepare("SELECT * FROM users WHERE link = ? AND is_active = 1 AND expires_at > NOW()");
        $statement->execute([$link]);

        return $statement->fetch();
    }

    public function deactivate(string $link): bool
    {
        $statement = $this->db->prepare("UPDATE users SET is_active = 0 WHERE link = ?");
        return $statement->execute([$link]);
    }

    public function regenerate(string $oldLink): string
    {
        $newLink = bin2hex(random_bytes(16));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

        $statement = $this->db->prepare("UPDATE users SET link = ?, expires_at = ?, is_active = 1 WHERE link = ?");
        $statement->execute([$newLink, $expiresAt, $oldLink]);

        return $newLink;
    }
}
