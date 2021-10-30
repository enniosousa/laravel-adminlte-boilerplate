<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', trans('models/users.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => Arr::toCssClasses(['form-control', 'is-invalid' => $errors->first('name')]),'maxlength' => 255]) !!}
    {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', trans('models/users.fields.email').':') !!}
    {!! Form::email('email', null, ['class' => Arr::toCssClasses(['form-control', 'is-invalid' => $errors->first('email')]),'maxlength' => 255]) !!}
    {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', trans('models/users.fields.password').':') !!}
    {!! Form::password('password', ['class' => Arr::toCssClasses(['form-control', 'is-invalid' => $errors->first('password')]),'maxlength' => 255]) !!}
    {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
</div>

<!-- Password Confirmation Field -->
<div class="form-group col-sm-4">
    <?= Form::label('password_confirmation', trans('models/users.fields.password_confirmation') . ':') ?>
    <?= Form::password('password_confirmation', ['class' => Arr::toCssClasses(['form-control', 'is-invalid' => $errors->first('password_confirmation')]), 'maxlength' => 255]) ?>
    <?= $errors->first('password_confirmation', '<div class="invalid-feedback">:message</div>') ?>
</div>