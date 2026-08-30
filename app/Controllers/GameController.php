<?php

declare(strict_types=1);

class GameController extends Controller
{
    private User $user;
    private Game $game;
    private array $validatedUser;

    public function __construct()
    {
        $this->user = new User();
        $this->game = new Game();

        $link = isset($_GET['token']) ? (string)$_GET['token'] : null;
        $user = $this->user->validateLink($link);

        if ($user === false) {
            header("Location: /?error=expired");
            exit;
        }

        $this->validatedUser = $user;
    }

    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = (string)($_POST['action'] ?? '');

            switch ($action) {
                case 'lucky':
                    $this->handleLucky();
                    break;
                case 'history':
                    $this->handleHistory();
                    break;
                case 'deactivate':
                    $this->handleDeactivate();
                    break;
                case 'regenerate':
                    $this->handleRegenerate();
                    break;
            }
        }

        $gameResult = $_SESSION['game_result'] ?? null;
        $history = $_SESSION['show_history'] ?? null;
        unset($_SESSION['game_result'], $_SESSION['show_history']);

        $this->render('page_a', [
            'user' => $this->validatedUser,
            'gameResult' => $gameResult,
            'history' => $history
        ]);
    }

    private function handleLucky(): void
    {
        $userId = (int)$this->validatedUser['id'];
        $link = (string)$this->validatedUser['link'];

        $_SESSION['game_result'] = $this->game->playLucky($userId);
        header("Location: /page-a?token=" . urlencode($link));
        exit;
    }

    private function handleHistory(): void
    {
        $userId = (int)$this->validatedUser['id'];
        $link = (string)$this->validatedUser['link'];

        $_SESSION['show_history'] = $this->game->getHistory($userId);
        header("Location: /page-a?token=" . urlencode($link));
        exit;
    }

    private function handleDeactivate(): void
    {
        $link = (string)$this->validatedUser['link'];

        $this->user->deactivate($link);
        header("Location: /");
        exit;
    }

    private function handleRegenerate(): void
    {
        $link = (string)$this->validatedUser['link'];

        $newLink = $this->user->regenerate($link);
        header("Location: /page-a?token=" . urlencode($newLink));
        exit;
    }
}
