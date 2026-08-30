<?php

declare(strict_types=1);

class Game
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function playLucky(int $userId): array
    {
        $randomNumber = rand(1, 1000);
        $isWin = ($randomNumber % 2 === 0);
        $winAmount = 0.0;

        if ($isWin) {
            $winRates = [
                900 => 0.70,
                600 => 0.50,
                300 => 0.30,
                0 => 0.10,
            ];

            foreach ($winRates as $threshold => $rate) {
                if ($randomNumber > $threshold) {
                    $winAmount = $randomNumber * $rate;
                    break;
                }
            }
        }

        $result = $isWin ? 'Win' : 'Lose';
        $statement = $this->db->prepare("INSERT INTO game_history (user_id, random_number, result, win_amount) VALUES (?, ?, ?, ?)");
        $statement->execute([$userId, $randomNumber, $result, $winAmount]);

        return [
            'number' => $randomNumber,
            'result' => $result,
            'amount' => round($winAmount, 2)
        ];
    }

    public function getHistory(int $userId): array
    {
        $statement = $this->db->prepare("SELECT random_number, result, win_amount FROM game_history WHERE user_id = ? ORDER BY id DESC LIMIT 3");
        $statement->execute([$userId]);
        return $statement->fetchAll();
    }
}
