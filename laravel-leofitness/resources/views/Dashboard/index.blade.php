@extends('app')

@section('content')

    <div class="rightside bg-grey-100">

        <div class="container-fluid">
            @can('manage-gymie')
            <!-- Stat Tile  -->
            <div class="row margin-top-10">
                <!-- Total Members -->
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <p>Total Miembros</p>
                </div>

                <!-- Registrations This Weeks -->
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <p>Registros en la semana</p>
                </div>

                <!-- Inactive Members -->
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <p>Miembros inactivos</p>
                </div>

                <!-- Members Expired -->
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <p>Miembros expirados</p>
                </div>

                <!-- Outstanding Payments -->
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <p>Miembros falta de pago</p>
                </div>

                <!-- Collection -->
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <p>Colleccion</p>
                </div>
            </div>
            @endcan

            <!--Member Quick views -->
            <div class="row"> <!--Main Row-->
                @can('manage-gymie')
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
                                <li class="active"><a href="#expiring" data-toggle="tab">Expirando<span
                                                class="label label-warning margin-left-5">expiringCount</span></a></li>
                                <li><a href="#expired" data-toggle="tab">Expirados<span class="label label-danger margin-left-5">expiredCount</span></a>
                                </li>
                                <li><a href="#birthdays" data-toggle="tab">Cumpleanos<span class="label label-success margin-left-5">birthdayCount</span></a>
                                </li>
                                <li><a href="#recent" data-toggle="tab">Recientes</a></li>
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
                                    <p>Miembros con cumpliendo anos</p>
                                </div>

                                <div class="tab-pane fade" id="recent">
                                   <p>Miembros</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('test')
                <!--Enquiry Quick view Tabs-->
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-title">
                            <div class="panel-head"><i class="fa fa-phone"></i><a >Enquiries</a></div>
                            <div class="pull-right"><a class="btn-sm btn-primary active" role="button"><i
                                            class="fa fa-phone"></i> Add</a></div>
                        </div>

                        <div class="panel-body with-nav-tabs">
                            <!-- Tabs Heads -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#enquiries" data-toggle="tab">Enquiries</a></li>
                                <li><a href="#reminders" data-toggle="tab">Reminders<span class="label label-warning margin-left-5">reminderCount</span></a>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="enquiries">
                                   <p>TODO</p>
                                </div>

                                <div class="tab-pane fade" id="reminders">
                                    <p>TODO</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div> <!--/Main row -->


            @can(['manage-gymie','view-dashboard-expense-tab'])
            <div class="row">
                <!--Expense Quick view Tabs-->
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-title">
                            <div class="panel-head"><i class="fa fa-inr"></i><a >Expenses</a></div>
                            <div class="pull-right"><a class="btn-sm btn-primary active" role="button">
                                    <i class="fa fa-inr"></i> Add</a>
                            </div>
                        </div>

                        <div class="panel-body with-nav-tabs">
                            <!-- Tabs Heads -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#due" data-toggle="tab">Due</a></li>
                                <li><a href="#outstanding" data-toggle="tab">Outstanding</a></li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="due">
                                    <p>TODO</p>
                                </div>

                                <div class="tab-pane fade" id="outstanding">
                                   <p>TODO</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>

            @can(['manage-gymie','view-dashboard-charts'])
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-title">
                            <div class="panel-head"><i class="fa fa-comments-o"></i>SMS Log</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="panel bg-light-blue-400">
                                        <div class="panel-body padding-15-20">
                                            <div class="clearfix">
                                                <div class="pull-left">
                                                    <div class="color-white font-size-24 font-roboto font-weight-600" data-toggle="counter" data-start="0"
                                                         data-from="0" data-speed="500"
                                                         data-refresh-interval="10"></div>
                                                </div>

                                                <div class="pull-right">
                                                    <i class="font-size-24 color-light-blue-100 fa fa-comments"></i>
                                                </div>

                                                <div class="clearfix"></div>

                                                <div class="pull-left">
                                                    <div class="display-block color-light-blue-50 font-weight-600">SMS balance</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="panel bg-white">
                        <div class="panel-title">
                            <div class="panel-head">Members Per Plan</div>
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
                            <div class="panel-head">Registration Trend</div>
                        </div>
                        <div class="panel-body no-padding-top">
                            <div id="gymie-registrations-trend" class="chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
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