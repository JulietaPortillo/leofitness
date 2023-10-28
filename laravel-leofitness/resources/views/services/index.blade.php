@extends('app')

@section('content')
    <div class="rightside bg-grey-100">

        <!-- BEGIN PAGE HEADING -->
        <div class="page-head bg-grey-100 padding-top-15 no-padding-bottom">
            @include('flash::message')
            <h1 class="page-title no-line-height">Servicios
                @permission(['manage-gymie','manage-services','add-service'])
                <a href="{{ route('services.create') }}" class="page-head-btn btn-sm btn-primary active" role="button">Agregar nuevo servicio</a>
                <small>Detalles de todos los servicios</small>
            </h1>
            @permission(['manage-gymie','pagehead-stats'])
            <h1 class="font-size-30 text-right color-blue-grey-600 animated fadeInDown total-count pull-right"><span data-toggle="counter" data-start="0"
                                                                                                                     data-from="0" data-to="{{ $count }}"
                                                                                                                     data-speed="600"
                                                                                                                     data-refresh-interval="10"></span>
                <small class="color-blue-grey-600 display-block margin-top-5 font-size-14">Cantidad total de servicios</small>
            </h1>
            @endpermission
            @endpermission
        </div><!-- / PageHead -->

        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel no-border ">
                        <div class="panel-body no-padding-top bg-white">
                            <div class="row margin-top-15 margin-bottom-15">
                                <div class="col-xs-12 col-md-3 pull-right">
                                    {!! Form::Open(['method' => 'GET']) !!}
                                    <div class="btn-inline pull-right">
                                        <input name="search" id="search" type="text" class="form-control padding-right-35" placeholder="Buscar...">
                                        <button class="btn btn-link no-shadow bg-transparent no-padding-top padding-right-10" type="button"><i
                                                    class="ion-search"></i></button>
                                    </div>
                                    {!! Form::Close() !!}

                                </div>
                            </div>

                            @if($services->count() == 0)
                                <h4 class="text-center padding-top-15">Lo sentimos! No se encontraron records.</h4>
                            @else

                                <table id="services" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Nombre del servicio</th>
                                        <th class="text-center">Descripcion</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($services as $service)
                                        <tr>
                                            <td class="text-center">{{ $service->name}}</td>
                                            <td class="text-center">{{ $service->description}}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info">Acciones</button>
                                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        @permission(['manage-gymie','manage-services','edit-service'])
                                                        <li>
                                                            <a href="{{ route('services.edit',['id' => $service->id]) }}">
                                                                Editar detalles
                                                            </a>
                                                        </li>
                                                        @endpermission
                                                        <?php
                                                        $dependency = ($service->plans->isEmpty() ? "false" : "true");
                                                        ?>
                                                        @permission(['manage-gymie','manage-services','delete-service'])
                                                        <li>
                                                            <a href="#"
                                                               class="delete-record"
                                                               data-dependency="{{ $dependency }}"
                                                               data-dependency-message="Tienes planes asociados a este servicio. No puedes eliminar este servicio."
                                                               data-delete-url="{{ url('plans/services/'.$service->id.'/delete') }}"
                                                               data-record-id="{{$service->id}}">
                                                                Eliminar servicio
                                                            </a>
                                                        </li>
                                                        @endpermission
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>

                                <!-- Pagination -->
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="gymie_paging_info">
                                            Mostrando pagina {{ $services->currentPage() }} de {{ $services->lastPage() }}
                                        </div>
                                    </div>

                                    <div class="col-xs-6">
                                        <div class="gymie_paging pull-right">
                                        {{ $services->links() }}
                                    </div>
                                </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_script_init')
    <script type="text/javascript">
        $(document).ready(function () {
            gymie.deleterecord();
        });
    </script>
@stop 