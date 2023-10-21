@extends('app')

@section('content')

    <div class="rightside bg-grey-100">

        <div class="container-fluid">
            @permission('Administrador')
            <!-- Stat Tile  -->
            <div class="row margin-top-10">
                <!-- Total Members -->
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    @include('dashboard._index.totalMembers')
                </div>

                <!-- Registrations This Weeks -->
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    @include('dashboard._index.registeredThisMonth')
                </div>

                <!-- Inactive Members -->
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <p>Miembros Expirados</p>
                </div>

                <!-- Members Expired -->
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    @include('dashboard._index.inActiveMembers')
                </div>

                <!-- Collection -->
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <p>Ingresos</p>
                </div>
            </div>
            @endpermission

            <!--Member Quick views -->
            <div class="row"> <!--Main Row-->
                @permission('Administrador')
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-title">
                            <div class="panel-head"><i class="fa fa-users"></i><a>Miembros</a></div>
                            <div class="pull-right"><a class="btn-sm btn-primary active" role="button"><i
                                            class="fa fa-user-plus"></i> Agregar</a></div>
                        </div>

                        <div class="panel-body with-nav-tabs">
                            <!-- Tabs Heads -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#expiring" data-toggle="tab">Expirados<span
                                                class="label label-warning margin-left-5">Total de Expirados</span></a></li>
                                <li><a href="#expired" data-toggle="tab">Inactivos<span class="label label-danger margin-left-5">Total de Inactivos</span></a>
                                </li>
                                <li><a href="#birthdays" data-toggle="tab">Cumpleañeros<span class="label label-success margin-left-5">Total de Cumpleañeros</span></a>
                                </li>
                                <li><a href="#recent" data-toggle="tab">Recientes<span class="label label-success margin-left-5">Total Recientes</span></a></li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="expiring">
                                    <p>Miembros que van a expirar</p>
                                </div>

                                <div class="tab-pane fade" id="expired">
                                    <p>Miembros ya expirados</p>
                                </div>

                                <div class="tab-pane fade" id="birthdays">
                                    <p>Miembros cumpleañeros</p>
                                </div>

                                <div class="tab-pane fade" id="recent">
                                   <p>Miembros</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endpermission
            </div> <!--/Main row -->

            @permission(['Administrador','view-dashboard-charts'])
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel bg-white">
                        <div class="panel-title">
                            <div class="panel-head">Miembros por Plan</div>
                        </div>
                        <div class="panel-body padding-top-10">
                                <div class="tab-empty-panel font-size-24 color-grey-300">
                                    <div id="gymie-members-per-plan" class="chart"></div>
                                    No Data
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel bg-white">
                        <div class="panel-title bg-transparent no-border">
                            <div class="panel-head">Tendencia de Registro</div>
                        </div>
                        <div class="panel-body no-padding-top">
                            <div id="gymie-registrations-trend" class="chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endpermission
        </div>
    </div>
@stop

@section('footer_scripts')
    <script src="{{ URL::asset('assets/plugins/morris/raphael-2.1.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
@stop

@section('footer_script_init')
    <script type="text/javascript">
        $(document).ready(function () {
            gymie.loadmorris();
        });
    </script>
@stop