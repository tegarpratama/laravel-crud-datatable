<table class="table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <td>{{ $model->id }}</td>
        </tr>
        <tr>
            <th>Title</th>
            <td>{{ $model->title }}</td>
        </tr>
        <tr>
            <th>Author</th>
            <td>{{ $model->user->name }}</td>
        </tr>
        <tr>
            <th>Cover</th>
            <td><img src="{{ $model->getCover() }}" height="150px"></td>
        </tr>
    </thead>
</table>
