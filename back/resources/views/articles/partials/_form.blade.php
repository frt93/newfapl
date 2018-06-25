<div id="formGroup">
    <hr>
    <div class="form-group">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>

    <div class="form-group" id="selectCategories">
        {!! Form::select('category_list[]', $categories, null, ['id' => 'categories', 'class' => 'form-control', 'multiple']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('title', 'Заголовок') !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('excerpt', 'Отрывок') !!}
        {!! Form::textarea('excerpt', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('body', 'Текст') !!}
        {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('published_at', 'Дата публикации') !!}
        {!! Form::input('datetime', 'published_at', $date, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('author', 'Автор') !!}
        {!! Form::text('author', $author, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::select('tag_list[]', $tags, null, ['id' => 'tags', 'class' => 'form-control', 'multiple']) !!}
    </div>
    <div class="form-group">
        {!! Form::select('competition_list[]', $competitions, null, ['id' => 'competitions', 'class' => 'form-control', 'multiple']) !!}
    </div>
    <div class="form-group">
        {!! Form::select('player_list[]', $players, null, ['id' => 'players', 'class' => 'form-control', 'multiple']) !!}
    </div>
    <div class="form-group">
        {!! Form::select('club_list[]', $clubs, null, ['id' => 'clubs', 'class' => 'form-control', 'multiple']) !!}
    </div>
    <div class="form-group">
        {!! Form::select('staff_list[]', $staff, null, ['id' => 'staff', 'class' => 'form-control', 'multiple']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>

    <select-plugin></select-plugin>
</div>