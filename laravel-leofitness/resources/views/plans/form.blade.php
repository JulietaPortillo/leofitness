<div class="panel-body">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('plan_code','Codigo del plan') !!}
                {!! Form::text('plan_code',null,['class'=>'form-control', 'id' => 'plan_code']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('plan_name','Nombre del plan') !!}
                {!! Form::text('plan_name',null,['class'=>'form-control', 'id' => 'plan_name']) !!}
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('plan_details','Detalles del plan') !!}
                {!! Form::text('plan_details',null,['class'=>'form-control', 'id' => 'plan_details']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php $services = App\Models\Service::lists('name', 'id'); ?>
                {!! Form::label('service_id','Servicios') !!}
                {!! Form::select('service_id',$services,null,['class'=>'form-control selectpicker show-tick show-menu-arrow','id'=>'service_id','data-live-search'=> 'true']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('days','Cantidad de dias') !!}
                {!! Form::text('days',null,['class'=>'form-control', 'id' => 'days']) !!}
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('amount','Precio') !!}
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-money"></i></div>
                    {!! Form::text('amount',null,['class'=>'form-control', 'id' => 'amount']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
            {!! Form::label('status','Status') !!}
            <!--0 for inactive , 1 for active-->
                {!! Form::select('status',array('1' => 'Activo', '0' => 'Inactivo'),null,['class' => 'form-control selectpicker show-tick show-menu-arrow', 'id' => 'status']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary pull-right']) !!}
            </div>
        </div>
    </div>
</div>
                            