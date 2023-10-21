<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AclController;
?>

@extends('app')

@section('content')

    <div class="rightside bg-grey-100">
        <!-- BEGIN PAGE HEADING -->
        <div class="page-head bg-grey-100">
            @include('flash::message')
            <h1 class="page-title">Permisos</h1>
            <a href="{{ route('permission.create') }}" class="btn btn-primary active pull-right" role="button"> Agregar</a></h1>
            
        </div>

        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel no-border ">
                        <div class="panel-title bg-white no-border">
                        </div>
                        <div class="panel-body no-padding-top bg-white">
                            <table id="staffs" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">Identificador</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Descripcion</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    @foreach ($permissions as $permission)
                                        <td class="text-center">{{ $permission->name}}</td>
                                        <td class="text-center">{{ $permission->display_name}}</td>
                                        <td class="text-center">{{ $permission->description}}</td>

                                        <td class="text-center">
                                            <a class="btn btn-info btn-sm" href="{{ route('permission.edit', ['id' => $permission->id]) }}">
                                                <i class="fa fa-edit "></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{$permission->id}}"
                                                    data-id="{{$permission->id}}">
                                                <i class="fa fa-trash-o "></i>
                                            </button>
                                        </td>
                                        <!-- Modal -->
                                        <div id="deleteModal-{{$permission->id}}" class="modal fade" permission="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Confirmar</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Estás seguro de que quieres eliminarlo?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                    {!! Form::open(['route' => ['permission.delete', $permission->id], 'method' => 'POST', 'id' => 'deleteform-' . $permission->id]) !!}
                                                        <input type="submit" class="btn btn-danger" value="Confirmar" id="btn-{{ $permission->id }}"/>
                                                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancelar</button>
                                                        {!! Form::Close() !!}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                </tr>

                                @endforeach


                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop