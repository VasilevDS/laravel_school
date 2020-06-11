<a class="bth bth-primary" href="{{ route('theme.create') }}">add</a></p>
@php /** @var \Illuminate\Support\ViewErrorBag $errors */ @endphp
@if($errors->any())
    {{ $errors->first() }}
@endif
@if(session('success'))
    {{ session()->get("success") }}
@endif
<table class="table table-hover">
    <thead>
    <tr>
        <th>id</th>
        <th>name</th>
    </tr>
    </thead>
    <tbody>
    @foreach($paginatedThemes as $theme)
        @php /** @var \App\Models\Theme $theme*/ @endphp
        <tr>
            <td>{{ $theme->id }}</td>
            <td>
                <a href="{{ route('theme.edit', $theme) }}">
                    {{ $theme->name }}
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@if ($paginatedThemes->total() > $paginatedThemes->count())

    {{ $paginatedThemes->links() }}
@endif



