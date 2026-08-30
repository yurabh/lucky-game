<?php

declare(strict_types=1);

class RegistrationController extends Controller
{
    public function index(): void
    {
        $this->render('register');
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim((string)($_POST['username'] ?? ''));
            $phone = trim((string)($_POST['phone'] ?? ''));

            if ($username !== '' && $phone !== '') {
                $user = new User();
                $link = $user->create($username, $phone);
                header("Location: /page-a?token=" . $link);
                exit;
            }
        }
        header("Location: /");
        exit;
    }
}
