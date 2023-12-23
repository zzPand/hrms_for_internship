
@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li class="">
                        <a href="#">
                            <li><a href="{{ route('home') }}">Dashboard</a></li>
                        </a>
                    </li>
                    @if (Auth::user()->role_name=='Admin')
                        <li class="menu-title"> <span>Authentication</span> </li>
                    @endif
                    <li class="">
                        <a class="active" href="{{ route('form/training/list/page') }}"> Assign Project </a>
                    </li>
                    <li class="">
                        <a class="active" href="{{ route('training/list2/page') }}"> Daily Report </a>
                    </li>
                    <li class="">
                        <a class="active" href="{{ route('training/list3/page') }}"> Monthly Report </a>
                    </li>
                    <li class="">
                        <a class="active" href="{{ route('training/list4/page') }}"> Final Report </a>
                    </li>
                    <li class="">
                        <a class="active" href="{{ route('notes') }}"> Log Book </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Sidebar -->

     <!-- Page Wrapper -->
     <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Daily Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Daily Report</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_training"><i class="fa fa-plus"></i> Add New </a>
                    </div>
                </div>
            </div>

        <!-- Add Training List Modal -->
        <div id="add_training" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('training2/save') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Yesterday Task</label>
                                            <input class="form-control" type="text" name="training_type" @error('training_type') is-invalid @enderror>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Name</label>
                                        <select class="select" id="trainer" name="trainer" @error('trainer') is-invalid @enderror>
                                            @foreach ($user as $items )
                                                <option selected disabled>-- Select --</option>
                                                <option value="{{ $items->name }}" data-trainer_id={{ $items->rec_id }}>{{ $items->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" id="trainer_id" name="trainer_id" readonly>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Today Task</label>
                                        <input class="form-control" type="text" name="today_task" @error('today_task') is-invalid @enderror>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" id="employees_id" name="employees_id" readonly>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Obstacle Faced <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="obstacle_faced" @error('obstacle_faced') is-invalid @enderror>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker @error('start_date') is-invalid @enderror" type="text" name="start_date">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Summary <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3"name="summary" @error('summary') is-invalid @enderror></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Status</label>
                                        <select class="select" name="status" @error('status') is-invalid @enderror>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Training List Modal -->

        <!-- /Display -->
        <div class="container">
            <h2>Report</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Yesterday Task</th>
                        <th>Today Task</th>
                        <th>Obstacle Faced</th>
                        <th>Summary</th>
                        <th>Start Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($training2 as $training)
                        <tr>
                            <td>{{ $training->trainer }}</td>
                            <td>{{ $training->training_type }}</td>
                            <td>{{ $training->today_task }}</td>
                            <td>{{ $training->obstacle_faced }}</td>
                            <td>{{ $training->summary }}</td>
                            <td>{{ $training->start_date }}</td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item edit_training" href="#" data-toggle="modal" data-target="#edit_training"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item delete_training" href="#" data-toggle="modal" data-target="#delete_training"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        <!-- Add this button -->
                                        <button class="btn btn-primary" id="exportPdf">Export to PDF</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /Display -->
        <!-- Edit Training List Modal -->
        <div id="edit_training" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('training2/update') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" id="e_id" name="id" value="">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Project Title</label>
                                            <input class="form-control" type="text" name="training_type" @error('training_type') is-invalid @enderror>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Project Owner</label>
                                        <select class="select" id="e_trainer" name="trainer">
                                            @foreach ($user as $items )
                                                <option selected disabled>-- Select --</option>
                                                <option value="{{ $items->name }}" data-e_trainer_id={{ $items->rec_id }}>{{ $items->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" id="e_trainer_id" name="trainer_id" readonly>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Framework</label>
                                        <select class="select" id="e_employees" name="employees">
                                            @foreach ($user as $items )
                                                <option selected disabled>-- Select --</option>
                                                <option value="{{ $items->name }}" data-e_employees_id={{ $items->rec_id }}>{{ $items->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" id="e_employees_id" name="employees_id" readonly>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Person Related <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="e_training_cost" name="training_cost" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Start Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="e_start_date" name="start_date" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>End Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" id="e_end_date" name="end_date" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" id="e_description" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Status</label>
                                        <select class="select" id="e_status" name="status">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Training List Modal -->

        <!-- Delete Training List Modal -->
        <div class="modal custom-modal fade" id="delete_training" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Project</h3>
                            <p>Are you sure want to delete this Project?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('training2/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Training List Modal -->

    </div>
    <!-- /Page Wrapper -->
    @section('script')
    <script>
        // select auto id and email
        $('#trainer').on('change',function()
        {
            $('#trainer_id').val($(this).find(':selected').data('trainer_id'));
        });
        $('#employees').on('change',function()
        {
            $('#employees_id').val($(this).find(':selected').data('employees_id'));
        });
    </script>
    <script>
        // select auto id and email
        $('#e_trainer').on('change',function()
        {
            $('#e_trainer_id').val($(this).find(':selected').data('e_trainer_id'));
        });
        $('#e_employees').on('change',function()
        {
            $('#e_employees_id').val($(this).find(':selected').data('e_employees_id'));
        });
    </script>

    {{-- update js --}}
    <script>
        $(document).on('click','.edit_training',function()
        {
            var _this = $(this).parents('tr');
            $('#e_id').val(_this.find('.e_id').text());
            $('#e_trainer_id').val(_this.find('.trainer_id').text());
            $('#e_today_task').val(_this.find('.today_task').text());
            $('#e_obstacle_faced').val(_this.find('.obstacle_faced').text());
            $('#e_start_date').val(_this.find('.start_date').text());
            $('#e_summary').val(_this.find('.summary').text());

            // training_type
            var training_type = (_this.find(".training_type").text());
            var _option = '<option selected value="' +training_type+ '">' + _this.find('.training_type').text() + '</option>'
            $( _option).appendTo("#e_training_type");

            // trainer
            var trainer = (_this.find(".trainer").text());
            var _option = '<option selected value="' +trainer+ '">' + _this.find('.trainer').text() + '</option>'
            $( _option).appendTo("#e_trainer");

            // employees
            var employees = (_this.find(".employees").text());
            var _option = '<option selected value="' +employees+ '">' + _this.find('.employees').text() + '</option>'
            $( _option).appendTo("#e_employees");

            // status
            var status = (_this.find(".status").text());
            var _option = '<option selected value="' +status+ '">' + _this.find('.status').text() + '</option>'
            $( _option).appendTo("#e_status");
        });
    </script>

    {{-- delete model --}}
    <script>
        $(document).on('click','.delete_training',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
        });
    </script>

<script>
    $(document).ready(function () {
        // DataTable initialization
        var table = $('#trainingTable').DataTable({
            // your DataTable options
        });

        // Add the export button
        $('#trainingTable_wrapper .dataTables_filter').append('<button class="btn btn-primary" id="exportPdf">Export to PDF</button>');

        // Export to PDF
        $('#exportPdf').on('click', function () {
            // Call your Laravel route for exporting to PDF
            $.ajax({
                url: '{{ route("training2/pdf") }}', // Change this to your Laravel route
                type: 'GET',
                success: function (response) {
                    // Trigger a download of the PDF
                    var blob = new Blob([response], { type: 'application/pdf' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'training_list.pdf';
                    link.click();
                }
            });
        });
    });
</script>
    @endsection
@endsection
