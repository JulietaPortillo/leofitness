<?php
use App\Http\Controllers\AclController;
?>
@extends('app')

@section('content')

    <div class="rightside bg-grey-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Ups!</strong>Ha ocurrido un error.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="panel no-border">
                        <div class="panel-title bg-white no-border">
                            <div class="panel-head">Ingrese los detalles del permiso</div>
                        </div>

                        {!! Form::open(['method' => 'POST', 'id' => 'permissionsform', 'route' => ['permission.update', $permission->id]]) !!}

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('name','Identificador') !!}
                                        {!! Form::text('name',$permission->name,['class'=>'form-control', 'id' => 'name']) !!}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('display_name','Nombre') !!}
                                        {!! Form::text('display_name',$permission->display_name,['class'=>'form-control', 'id' => 'display_name']) !!}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('description','Descripcion') !!}
                                        {!! Form::text('description',$permission->description,['class'=>'form-control', 'id' => 'description']) !!}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('group_key','Grupo') !!}
                                        {!! Form::text('group_key',$permission->group_key,['class'=>'form-control', 'id' => 'group_key']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2 pull-right">
                            <div class="form-group">
                                {!! Form::submit('Actualizar', ['class' => 'btn btn-primary pull-right']) !!}
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