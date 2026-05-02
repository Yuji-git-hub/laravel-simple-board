<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿一覧画面</title>
</head>
<body>
    <h1>掲示板一覧</h1>
    @auth
    <a href="{{ route('boards.create') }}">+新規投稿</a>
    @endauth

    @if(session('success'))
        {{ session('success')}}
    @endif

    @foreach($boards as $board)
        <h2>タイトル: {{ $board->title }}</h2>
        <p>{{ $board->body }}</p>
        <small>投稿者: {{ $board->user->name }}</small>
        <small>{{ $board->created_at->diffForHumans() }}</small>
    @endforeach
</body>
</html>