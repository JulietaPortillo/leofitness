<?php 
use Carbon\Carbon;
use App\Lubus\Constants; 
?>

<!-- Hidden Fields -->
@if(Request::is('members/create'))
    {!! Form::hidden('invoiceCounter',$invoiceCounter) !!}
    {!! Form::hidden('memberCounter',$memberCounter) !!}
@endif

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('member_code','Codigo del miembro') !!}
            {!! Form::text('member_code',$member_code,['class'=>'form-control', 'id' => 'member_code', ($member_number_mode == Constants::Auto ? 'readonly' : '')]) !!}
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('name','Nombre y Apellido',['class'=>'control-label']) !!}
            {!! Form::text('name',null,['class'=>'form-control', 'id' => 'name']) !!}
        </div>
    </div>
</div>

<div class="row">

    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('DOB','Fecha de nacimiento') !!}
            {!! Form::text('DOB',null,['class'=>'form-control datepicker-default', 'id' => 'DOB']) !!}
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('gender','Sexo') !!}
            {!! Form::select('gender',array('m' => 'Male', 'f' => 'Female'),null,['class'=>'form-control selectpicker show-tick show-menu-arrow', 'id' => 'gender']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('contact','Numero de telefono') !!}
            {!! Form::text('contact',null,['class'=>'form-control', 'id' => 'contact']) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('email','Correo') !!}
            {!! Form::text('email',null,['class'=>'form-control', 'id' => 'email']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('emergency_contact','Contacto de emergencia') !!}
            {!! Form::text('emergency_contact',null,['class'=>'form-control', 'id' => 'emergency_contact']) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('health_issues','Problemas de salud') !!}
            {!! Form::text('health_issues',null,['class'=>'form-control', 'id' => 'health_issues']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('proof_name','Nombre preferido') !!}
            {!! Form::text('proof_name',null,['class'=>'form-control', 'id' => 'proof_name']) !!}
        </div>
    </div>


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
            {!! Form::label('aim','Objetivo?',['class'=>'control-label']) !!}
            {!! Form::select('aim',array('0' => 'Fitness', '1' => 'Yoga', '2' => 'Crecer musculos', '3' => 'Perder grasa', '4' => 'Aumentar', '5' => 'Otro'),null,['class' => 'form-control selectpicker show-tick show-menu-arrow', 'id' => 'aim']) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('source','Como nos conociste?',['class'=>'control-label']) !!}
            {!! Form::select('source',array('0' => 'Promociones', '1' => 'Redes Sociales', '2' => 'Otros'),null,['class' => 'form-control selectpicker show-tick show-menu-arrow', 'id' => 'source']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {!! Form::label('occupation','Ocupacion') !!}
                    {!! Form::select('occupation',array('0' => 'Estudiante', '1' => 'Deportista','2' => 'Propia empresa','3' => 'Profesional','4' => 'Desarrollador','5' => 'Otros'),null,['class' => 'form-control selectpicker show-tick show-menu-arrow', 'id' => 'occupation']) !!}
                </div>
            </div>


            <div class="col-sm-12">
                <div class="form-group">
                    {!! Form::label('pin_code','Codigo pin',['class'=>'control-label']) !!}
                    {!! Form::text('pin_code',null,['class'=>'form-control', 'id' => 'pin_code']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('address','Direccion') !!}
            {!! Form::textarea('address',null,['class'=>'form-control', 'id' => 'address', 'rows' => 5]) !!}
        </div>
    </div>
</div>