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
        <div class="col-md-12">
            {{--  btn add project  --}}
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProject">
                <i class="fas fa-plus"></i> Add Project
            </button>

            <table id="tableProject" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{--  Modal Add Project  --}}
    <div class="modal fade bd-example-modal-lg" id="addProject">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Project</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-grup mb-3">
                                    <label for="name">Nama Project</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nama Project" value="{{ old('name') }}">
                                </div>

                                <div class="form-grup mb-3">
                                    <label for="short_description">Description</label>
                                    <textarea name="short_description" placeholder="Description" rows="3" class="d-block w-100 form-control">{{ old('short_description') }}</textarea>
                                </div>

                                <div class="form-grup mb-3">
                                    <label for="long_description">Description Detail</label>
                                    <input id="long_description" type="hidden" name="long_description">
                                    <trix-editor input="long_description"></trix-editor>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="image">Project Image</label>
                                    <img class="img-fluid img-preview col-sm-5 mb-3">
                                    <input type="file" class="form-control" name="image" multiple accept="image/*" id="image" onchange="previewImage()">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="role">Role</label>
                                    <input type="text" class="form-control" name="role" placeholder="Role" value="{{ old('role') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="project_role_description">Project Role Description</label>
                                    <input id="project_role_description" type="hidden" name="project_role_description">
                                    <trix-editor input="project_role_description"></trix-editor>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tools_project">Tools</label>
                                    <input type="text" class="form-control mb-2" name="tools_project" placeholder="Add Tools" value="{{ old('tools_project') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="linkproject">Link Project</label>
                                    <input type="text" class="form-control" name="linkproject" placeholder="Link Project" value="{{ old('linkproject') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="linkgithub">Link Github</label>
                                    <input type="text" class="form-control" name="linkgithub" placeholder="Link Github" value="{{ old('linkgithub') }}">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- Footer modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="editProject">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Project</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-grup mb-3">
                                    <label for="name">Nama Project</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nama Project" value="{{ old('name') }}">
                                </div>

                                <div class="form-grup mb-3">
                                    <label for="short_description">Description</label>
                                    <textarea name="short_description" placeholder="Description" rows="3" class="d-block w-100 form-control">{{ old('short_description') }}</textarea>
                                </div>

                                <div class="form-grup mb-3">
                                    <label for="long_description">Description Detail</label>
                                    <input id="long_description" type="hidden" name="long_description">
                                    <trix-editor input="long_description"></trix-editor>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="image">Project Image</label>
                                    <img class="img-fluid img-preview col-sm-5 mb-3">
                                    <input type="file" class="form-control" name="image" multiple accept="image/*" id="image" onchange="previewImage()">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="role">Role</label>
                                    <input type="text" class="form-control" name="role" placeholder="Role" value="{{ old('role') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="project_role_description">Project Role Description</label>
                                    <input id="project_role_description" type="hidden" name="project_role_description">
                                    <trix-editor input="project_role_description"></trix-editor>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tools_project">Tools</label>
                                    <input type="text" class="form-control mb-2" name="tools_project" placeholder="Add Tools" value="{{ old('tools_project') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="linkproject">Link Project</label>
                                    <input type="text" class="form-control" name="linkproject" placeholder="Link Project" value="{{ old('linkproject') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="linkgithub">Link Github</label>
                                    <input type="text" class="form-control" name="linkgithub" placeholder="Link Github" value="{{ old('linkgithub') }}">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- Footer modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
