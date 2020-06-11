<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Theme edit</title>
</head>
<body>
<form method="POST" action="{{ route('theme.store') }}">
    @csrf
    @php /** @var \Illuminate\Support\ViewErrorBag $errors */ @endphp
    @if($errors->any())
        {{ $errors->first() }}
    @endif
    @if(session('success'))
        {{ session()->get("success") }}
    @endif
    <p><b>Имя новой темы:</b><br>
        <input type="text" name="name">
    </p>
    <button type="submit">save</button>
    </p>
</form>
<form action="/theme/">
    <button type="submit">back</button>
</form>
</body>
</html>
