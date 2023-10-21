@extends('app')

@section('content')

    <div class="rightside bg-grey-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Ups!</strong> Ha ocurrido un error.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="panel no-border">
                        <div class="panel-title">
                            <div class="panel-head">Ingrese los detalles del rol</div>
                        </div>

                        {!! Form::Open(['url' => 'user/role','id' => 'rolesform','files'=>'true']) !!}

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('name','Identificador') !!}
                                        {!! Form::text('name',null,['class'=>'form-control', 'id' => 'name']) !!}
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('display_name','Nombre') !!}
                                        {!! Form::text('display_name',null,['class'=>'form-control', 'id' => 'display_name']) !!}
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('description','Descripcion') !!}
                                        {!! Form::text('description',null,['class'=>'form-control', 'id' => 'description']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel no-border">
                        <div class="panel-title">
                            <div class="panel-head">Seleccione Permisos</div>
                        </div>
                        <div class="panel-body">

                            @foreach($permissions->groupBy('group_key') as $permission_group)
                                <h5>{{$permission_group->pluck('group_key')->pop()}}</h5>
                                <div class="row">
                                    @foreach($permission_group as $permission)
                                        <div class="col-xs-4">
                                            <div class="checkbox checkbox-theme">
                                                <input type="checkbox" name="permissions[]" id="permission_{{$permission->id}}" value="{{$permission->id}}">
                                                <label for="permission_{{$permission->id}}">{{ $permission->display_name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2 pull-right">
                            <div class="form-group">
                                {!! Form::submit('Crear', ['class' => 'btn btn-primary pull-right']) !!}
                            </div>
                        </div>
                    </div>

                    {!! Form::Close() !!}


                </div>
            </div>
        </div>
    </div>
    </div>

@stop