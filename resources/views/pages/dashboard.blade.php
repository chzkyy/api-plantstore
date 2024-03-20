@extends('layouts.admin')

@section('title')
    {{ $title }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> {{ $title }} </h1>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Experience
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $experience->count()  }} Experience
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Project
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $project->count() }}
                                Project
                            </div>
                        </div>
                        <div class="col-auto">
                            {{--  <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>  --}}
                            <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Skills
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $skill->count() }}
                                skills
                            </div>
                        </div>
                        <div class="col-auto">
                            {{--  icon skills  --}}
                            <i class="fas fa-code fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
