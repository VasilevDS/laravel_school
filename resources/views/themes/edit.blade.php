<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Theme edit</title>
</head>
<body>
<form method="POST" action="{{ route('theme.update', $theme->id) }}">
    @method('PATCH')
    @csrf
    @php /** @var \Illuminate\Support\ViewErrorBag $errors */ @endphp
    @if($errors->any())
        {{ $errors->first() }}
    @endif
    @if(session('success'))
        {{ session()->get("success") }}
    @endif
    <p><input type="text" name="name" value=" {{ $theme->name }} "></p>
    <button type="submit">Обновить</button>
    </p>
</form>
<form method="POST" action="{{ route('theme.destroy', $theme->id) }}">
    @method('delete')
    @csrf
    <button type="submit">Удалить</button>
    </p>
</form>
<form action="/theme/">
    <button type="submit">Назад</button>
</form>
</body>
</html>
