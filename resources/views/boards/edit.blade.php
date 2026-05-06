<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿編集画面</title>
</head>
<body>
    <a href="{{ route('boards.index') }}">←投稿一覧に戻る</a>
    <h1>投稿編集画面</h1>

    <form action="{{ route('boards.update', $board) }}" method="post">
        @csrf
        @method('PUT')
        <div>
            <label for="title">タイトル: </label>
            <input type="text" name="title" value="{{ old('title') }}">
        </div>
        <div>
            <label for="body">コメント: </label>
            <input type="text" name="body" value="{{ old('body') }}">
        </div>
        <input type="submit" value="更新">
    </form>
</body>
</html>