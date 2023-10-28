@extends('app')

@section('content')
    <div class="rightside bg-grey-100">

        <!-- BEGIN PAGE HEADING -->
        <div class="page-head bg-grey-100 padding-top-15 no-padding-bottom">
            @include('flash::message')
            <h1 class="page-title no-line-height">Planes
                @permission(['manage-gymie','manage-Planes','add-plan'])
                <a href="{{ route('plans.create') }}" class="page-head-btn btn-sm btn-primary active" role="button">Agregar nuevo plan</a>
                <small>Detalles de todos los planes</small>
            </h1>
            @permission(['manage-gymie','pagehead-stats'])
            <h1 class="font-size-30 text-right color-blue-grey-600 animated fadeInDown total-count pull-right">
                <span data-toggle="counter" data-start="0"
                      data-from="0" data-to="{{ $count }}"
                      data-speed="600"
                      data-refresh-interval="10"></span>
                <small class="color-blue-grey-600 display-block margin-top-5 font-size-14">Cantidad total de planes</small>
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
                                        <button class="btn btn-link no-shadow bg-transparent no-padding-top padding-right-10" type="button">
                                            <i class="ion-search"></i></button>
                                    </div>
                                    {!! Form::Close() !!}

                                </div>
                            </div>

                            @if($plans->count() == 0)
                                <h4 class="text-center padding-top-15">Lo siento! No se pudo encontrar.</h4>
                            @else

                                <table id="Planes" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombre de plan</th>
                                        <th>Nombre de servicio</th>
                                        <th>Detalles de plan</th>
                                        <th>Dias</th>
                                        <th>Cantidad</th>
                                        <th>Status</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($plans as $plan)
                                        <tr>
                                            <td>{{ $plan->plan_code}}</td>
                                            <td>{{ $plan->plan_name}}</td>
                                            <td>{{ $plan->service->name}}</td>
                                            <td>{{ $plan->plan_details}}</td>
                                            <td>{{ $plan->days}}</td>
                                            <td>{{ $plan->amount}}</td>
                                            <td>
                                                <span class="{{ Utilities::getActiveInactive ($plan->status) }}">{{ Utilities::getStatusValue ($plan->status) }}</span>
                                            </td>

                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info">Acciones</button>
                                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            @permission(['manage-gymie','manage-Planes','edit-plan'])
                                                            <a href="{{ route('plans.edit',['id' => $plan->id]) }}">
                                                                Editar detalles
                                                            </a>
                                                            @endpermission
                                                        </li>
                                                        <li>
                                                            
                                                        </li>
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
                                            Mostrando pagina {{ $plans->currentPage() }} de {{ $plans->lastPage() }}
                                        </div>
                                    </div>

                                    <div class="col-xs-6">
                                        <div class="gymie_paging pull-right">
                                            {!! str_replace('/?', '?', $plans->appends(request()->only('search'))->render()) !!}
                                        </div>
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