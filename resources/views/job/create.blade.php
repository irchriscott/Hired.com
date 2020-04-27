@extends('layouts.app')

@section('content')
<section class="generic-banner relative">		
	<div class="container">
		<div class="row align-items-center justify-content-center hd-cover-small">
			<div class="col-lg-10">
				<div class="generic-banner-content">
                    <h1 class="text-white" style="text-transform:uppercase;">Add New {{ $type }}</h1>
                    @if($type == 'Job')
                    <p class="text-white">Any work or occupation that can last for certain time. Salary is optional. This can be internship as well.</p>
                    @elseif($type == 'Service')
                    <p class="text-white">A service is a short time job, work or occupation that might or might not require salary.</p>
                    @endif
				</div>							
			</div>
        </div>
    </div>
</section>
<section class="hd-add-new">
    <div class="hd-add-form-else" style="margin-bottom:30px;">
        {!! Form::open(['url' => route('job.store'), 'method' => 'POST']) !!}
            @if($type == 'Job')
            {!! Form::hidden('job_type', 'job') !!}
            @elseif($type == 'Service')
            {!! Form::hidden('job_type', 'service') !!}
            @endif
            {!! Form::label('title', $type . ' Title : ') !!}
            {!! Form::text('title', '', ['class' => 'form-control', 'requited' => true, 'placeholder' => 'Enter ' . $type . ' Title', 'autocomplete' => 'off']) !!}
            <br/>
            @if($type == 'Job')
            {!! Form::label('position', $type . ' Position : ') !!}
            {!! Form::text('position', '', ['class' => 'form-control', 'requited' => true, 'placeholder' => 'Enter ' . $type . ' Position', 'autocomplete' => 'off']) !!}
            <br/>
            @else
            {!! Form::hidden('position', 'service') !!}
            @endif
            <div class="hd-form-salary">
                {!! Form::label('salary', 'Salary (optional) : ') !!}
                {!! Form::number('min_salary', '', ['class' => 'form-control', 'placeholder' => 'Minimum Salary']) !!}
                {!! Form::number('max_salary', '', ['class' => 'form-control', 'placeholder' => 'Maximum Salary']) !!}
                <select name="currency" class="form-control">
                    @foreach($currencies as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                <select name="per" class="form-control">
                    @foreach($pers as $per)
                        <option value="{{ $per }}">{{ $per }}</option>
                    @endforeach
                </select>
            </div>
            <br/>
            <div class="hd-form-duration">
                {!! Form::label('duration', $type . ' Duration : ') !!}
                <div id="general">
                    {!! Form::number('duration', '', ['class' => 'form-control', 'placeholder' => 'Enter Duration Number', 'min' => '1', 'id' => 'hd-job-duration', 'data-value' => '1']) !!}
                    <select name="duration_type" class="form-control">
                        @foreach($pers as $per)
                            <option value="{{ $per }}">{{ $per }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="specific" style="display:none;">
                    {!! Form::text('from_date', '', ['class' => 'form-control', 'placeholder' => 'From Date', 'id' => 'hd-from-date', 'autocomplete' => 'off']) !!}
                    {!! Form::text('to_date', '', ['class' => 'form-control', 'placeholder' => 'To Date', 'id' => 'hd-to-date', 'autocomplete' => 'off']) !!}
                </div>
                <p style="margin-top:8px;"><input type="checkbox" id="specify" /> Specify Duration</p>
            </div>
            <br/>
            {!! Form::label('deadline', 'Deadline : ') !!}
            {!! Form::text('deadline', '', ['class' => 'form-control', 'requited' => true, 'placeholder' => 'Enter Deadline', 'id' => 'hd-deadline-date', 'autocomplete' => 'off']) !!}
            <br/>
            {!! Form::label('description', 'Describe the ' . $type . ' : ') !!}
            {!! Form::textarea('description', '', ['class' => 'form-control', 'id' => 'hd-job-description']) !!}
            <br/>
            @if($type == 'Job')
            <p>{!! Form::checkbox('is_remote', true, true) !!} Can be remote</p>
            @else
            {!! Form::hidden('is_remote', '0') !!}
            @endif
            <p>{!! Form::checkbox('can_comment', true, true) !!} Allow Comments</p>
            <button type="submit" class="genric-btn primary radius">
                {{ __('Save') }}
            </button>
            @if($type == 'Job')
            <a class="genric-btn danger-border radius" href="{{ route('session.jobs') }}">
                {{ __('Cancel') }}
            </a>
            @elseif($type == 'Service')
            <a class="genric-btn danger-border radius" href="{{ route('session.services') }}">
                {{ __('Cancel') }}
            </a>
            @endif
        {!! Form::close() !!}
    </div>
    <style type="text/css">
        .fr-placeholder{
            font-size: 14px !important;
            padding: 0.375rem 0.75rem !important;
        } 
        .fr-wrapper{
            padding: 0.375rem 0.75rem;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            margin-bottom: -15px;
        }
    </style>
</section>
@endsection