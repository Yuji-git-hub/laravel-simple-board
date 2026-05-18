<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿詳細画面</title>
</head>
<body>
    <a href="{{ route('boards.index') }}">← 投稿一覧に戻る</a>

    <h2>タイトル: {{ $board->title }}</h2>

    <p>{{ $board->body }}</p>

    <p>投稿者: {{ $board->user->name }}</p>

    <p>{{ $board->created_at }}</p>
</body>
</html>