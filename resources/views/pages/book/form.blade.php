{!! Form::model($model, [
    'route' => $model->exists ? ['book.update', $model->id] : 'book.store',
    'method' => $model->exists ? 'PUT' : 'POST',
    'files' => true,
]) !!}

    <div class="form-group">
        <label for="">Title</label>
        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
    </div>

    <div class="form-group">
        <label for="">Author</label>
        {!! Form::select('user_id', $users, null, ['class' => 'form-control', 'id' => 'user_id']) !!}
    </div>

    <div class="form-group @error('cover') has-error @enderror">
        <label for="">Cover</label>

        {{-- <input type="file" name="cover" class="form-control-file">
        @error('cover')
            <span class="text-danger help-block">{{ $message }}</span>
        @enderror --}}
        @if (isset($model->cover))
            <img src="{{ $model->getCover() }}" height="150px">
        @endif
        <br>
        {!! Form::file('cover', $users,['class' => 'form-control-file', 'id' => 'cover']) !!}
    </div>

{!! Form::close() !!}
