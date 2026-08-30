<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>Сторінка А</title>
</head>

<body>
<h2>Вітаємо, <?= htmlspecialchars((string)$data['user']['username'], ENT_QUOTES, 'UTF-8') ?>!</h2>
<p>Ваше унікальне посилання діє
    до: <?= htmlspecialchars((string)$data['user']['expires_at'], ENT_QUOTES, 'UTF-8') ?></p>

<div style="display: flex; gap: 10px;">
    <form action="/page-a?token=<?= urlencode((string)$data['user']['link']) ?>" method="POST">
        <input type="hidden" name="action" value="lucky">
        <button type="submit">Imfeelinglucky</button>
    </form>

    <form action="/page-a?token=<?= urlencode((string)$data['user']['link']) ?>" method="POST">
        <input type="hidden" name="action" value="history">
        <button type="submit">History</button>
    </form>

    <form action="/page-a?token=<?= urlencode((string)$data['user']['link']) ?>" method="POST">
        <input type="hidden" name="action" value="regenerate">
        <button type="submit">Regenerate Link</button>
    </form>

    <form action="/page-a?token=<?= urlencode((string)$data['user']['link']) ?>" method="POST">
        <input type="hidden" name="action" value="deactivate">
        <button type="submit">Deactivate Link</button>
    </form>
</div>

<?php if (!empty($data['gameResult'])): ?>
    <div style="margin-top: 20px; padding: 10px; border: 1px solid green; background: #e6ffe6;">
        <h3>Результат гри:</h3>
        <p>Рандомне число: <b><?= (int)$data['gameResult']['number'] ?></b></p>
        <p>Результат: <b><?= htmlspecialchars((string)$data['gameResult']['result'], ENT_QUOTES, 'UTF-8') ?></b></p>
        <p>Сума виграшу: <b><?= (float)$data['gameResult']['amount'] ?> грн</b></p>
    </div>
<?php endif; ?>

<?php if (!empty($data['history'])): ?>
    <div style="margin-top: 20px; padding: 10px; border: 1px solid #ccc;">
        <h3>Історія останніх 3-х спроб:</h3>
        <ul>
            <?php foreach ((array)$data['history'] as $game): ?>
                <li>
                    Число: <b><?= (int)$game['random_number'] ?></b> |
                    Результат: <b><?= htmlspecialchars((string)$game['result'], ENT_QUOTES, 'UTF-8') ?></b> |
                    Виграш: <b><?= (float)$game['win_amount'] ?> грн</b>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
</body>
</html>
