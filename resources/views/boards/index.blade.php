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
        {{ session('success') }}
    @endif

    <form action="{{ route('boards.index') }}" method="get">
        <div>
            <label for="title">タイトル: </label>
            <input type="text" name="keyword" value="{{ request('keyword') }}">
        </div>
        <div>
            <label for="body">コメント: </label>
            <input type="text" name="body" value="{{ request('body') }}">
        </div>
        <button type="submit">検索</button>
    </form>

    <form action="{{ route('boards.index') }}" method="get">
        <button type="submit">リセット</button>
    </form>

    <form action="{{ route('boards.index') }}" method="get">
        <input type="text" name="name" value="{{ request('name') }}">
        <button type="submit">投稿者検索</button>
    </form>

    <form action="{{ route('boards.index') }}" method="get">
        <select name="sort">
            <option value="latest"
                {{ request('sort') === 'latest' ? 'selected' : '' }}>
                新しい順
            </option>

            <option value="old"
                {{ request('sort') === 'old' ? 'selected' : '' }}>
                古い順
            </option>
        </select>

        <button type="submit">並び替え</button>
    </form>

    @foreach($boards as $board)
        <h2>
            <a href="{{ route('boards.show', $board) }}">
                タイトル: {{ $board->title }}
            </a>
        </h2>
        <p>{{ $board->body }}</p>
        <small>投稿者: {{ $board->user->name }}</small>
        <small>{{ $board->created_at->diffForHumans() }}</small>
        @can('update', $board)
            <a href="{{ route('boards.edit', $board) }}">編集</a>
        @endcan
        @can('delete', $board)
            <form action="{{ route('boards.destroy', $board) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit">削除</button>
            </form>
        @endcan
    @endforeach

    {{ $boards->links() }}
</body>
</html>