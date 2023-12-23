
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
                        <h3 class="page-title">Final Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Final Report</li>
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
                <form action="{{ route('training4/save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Student ID:</label>
                                            <input class="form-control" type="text" name="students" @error('students') is-invalid @enderror>
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Company Background</label>
                                            <input class="form-control" type="text" name="training_type" @error('training_type') is-invalid @enderror>
                                    </div>
                                </div>

                        <!-- Image Upload Section -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Upload Images (Optional)</label>
                                <div id="imageContainer">
                                    @for ($i = 1; $i <= 8; $i++)
                                        <input type="file" name="images[]" accept="image/*" class="form-control mt-2">
                                    @endfor
                                </div>
                            </div>
                        </div>
                                <input type="hidden" class="form-control" id="trainer_id" name="trainer_id" readonly>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Projects/Tasks/Assignments</label>
                                        <div id="projectContainer">
                                            @if(isset($training->today_tasks))
                                                @foreach($training->today_tasks as $project)
                                                    <div class="project-group mb-4">
                                                        <input class="form-control" type="text" name="project_headers[]" placeholder="Project Header" value="{{ $project['header'] }}" required>
                                                        <input class="form-control mt-2" type="text" name="project_overviews[]" placeholder="Project Overview" value="{{ $project['overview'] }}" required>
                                                        <input class="form-control mt-2" type="text" name="problem_encountered[]" placeholder="Problem Encountered" value="{{ $project['problem'] }}" required>
                                                        <input class="form-control mt-2" type="text" name="solutions[]" placeholder="Solutions" value="{{ $project['solution'] }}" required>
                                                        <button class="btn btn-danger remove-project" type="button">Remove Header</button>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="project-group mb-4">
                                                    <input class="form-control" type="text" name="project_headers[]" placeholder="Project Header" required>
                                                    <input class="form-control mt-2" type="text" name="project_overviews[]" placeholder="Project Overview" required>
                                                    <input class="form-control mt-2" type="text" name="problem_encountered[]" placeholder="Problem Encountered" required>
                                                    <input class="form-control mt-2" type="text" name="solutions[]" placeholder="Solutions" required>
                                                    <button class="btn btn-success add-project" type="button">Add Header</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Conclusion</label>
                                            <input class="form-control" type="text" name="conclusion" @error('conclusion') is-invalid @enderror>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" id="employees_id" name="employees_id" readonly>

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

        <!-- display -->
        <style>
            .bg-white {
                overflow: hidden;
                word-wrap: break-word;
            }

            .dropdown-menu-right {
                right: 0;
                left: auto;
                z-index: 1000; /* Ensure a high z-index value */
            }

            .display-images img {
                max-width: 100%;
                max-height: 200px; /* Adjust the maximum height as needed */
                margin-top: 10px;
            }

            /* Add new styles for custom formatting */
            .center-title {
                text-align: center;
                font-weight: bold;
                font-size: 24px;
                margin-bottom: 20px;
            }

            .report-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            .report-table th, .report-table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            .section-title {
                font-weight: bold;
                font-size: 18px;
                margin-top: 20px;
            }

            .sub-title {
                font-weight: bold;
                font-size: 16px;
                margin-top: 10px;
            }

            .break {
                margin-top: 20px;
            }

            .display-images img {
    max-width: 80%;
    max-height: 460px; /* Adjust the maximum height as needed */
    width: 50%;
    margin-top: 10px;
}

.logo-container {
        text-align: center;
        margin-top: 20px; /* Adjust the margin-top as needed */
    }

    .logo-container img {
        max-width: 100%; /* Ensure the image doesn't exceed its container */
        height: auto; /* Maintain the aspect ratio of the image */
    }
        </style>

        <!-- MMU Logo -->
<div class="logo-container">
    <img src="{{ asset('images/mmuLogo.jpg') }}" alt="Logo">
</div>

        <div class="container">
            <h2 class="center-title" style="font-size: 22px;">INDUSTRIAL TRAINING</h2>

            <!-- Table -->
            <table class="report-table">
                <thead>
                    <tr style="font-size: 18px;">
                        <th>No.</th>
                        <th>Student ID</th>
                        <th>Student Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($training4 as $key => $training)
                        <tr style="font-size: 18px;">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $training->students }}</td>
                            <td>{{ $training->trainer }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Table of Contents -->
<div class="break" style="font-size: 18px;">
    <div class="table-of-contents" style="font-weight: bold;">Table of Contents</div>
    <div style="font-weight: bold;">1.0 Introduction</div>
    <div class="content-subtitle" style="margin-left: 80px; font-weight: bold;">1.1 Company Background</div><br>
    <div style="font-weight: bold;">2.0 IT Related Projects/Tasks/Assignments</div>
    <div class="content-subtitle" style="margin-left: 80px; font-weight: bold;">2.1 Develop an education services</div>
    <div class="content-subtitle" style="margin-left: 80px; font-weight: bold;">Project Overview</div>
    <div class="content-subtitle" style="margin-left: 80px; font-weight: bold;">Problem Encountered and Solutions</div><br>
    <div style="font-weight: bold;">3.0 Conclusion</div>
    <div style="font-weight: bold;">4.0 Appendix</div>
    <div class="content-subtitle" style="margin-left: 80px; font-weight: bold;">4.1 Weekly Report</div>
    <div class="content-subtitle" style="margin-left: 80px; font-weight: bold;">4.2 Monthly Report</div>
</div>

            <!-- Title Company Section -->
            <div class="section-title break" style="font-size: 18px;">Company</div>
            <div class="sub-title break" style="font-size: 18px;">1.1 Company background</div>
            @foreach ($training4 as $training)
                <div style="font-size: 18px;">{{ $training->training_type }}</div>
            @endforeach

            <!-- IT Related Projects Section -->
            <div class="section-title break" style="font-size: 18px;">IT Related Projects</div>
            @foreach ($training4 as $training)
            @foreach ($training->today_tasks as $task)
                <div class="sub-title break" style="font-size: 18px;">{{ $task['header'] }}</div>
                <div class="break" style="font-size: 18px;"><strong>Project Overview:</strong> {{ $task['overview'] }}</div>
                <!-- Display Images Section -->
                <div class="display-images">
                    @if(count($training->images) > 0)
                        <strong>Images:</strong><br>
                        @foreach($training->images as $image)
                            <img src="{{ asset('storage/images/' . $image->image_path) }}" alt="Image">
                        @endforeach
                    @endif
                </div>
                <div class="break" style="font-size: 18px;"><strong>Problems Encountered:</strong> {{ $task['problem'] }}</div>
                <div class="break" style="font-size: 18px;"><strong>Solutions:</strong> {{ $task['solution'] }}</div>
            @endforeach
        @endforeach


            <!-- Conclusion Section -->
            <div class="content-title break" style="font-size: 18px;">3.0 Conclusion</div>
            @foreach ($training4 as $training)
                <div class="break" style="font-size: 18px;">{{ $training->conclusion }}</div>
            @endforeach


                        <!-- Appendix Section --><!-- /Display --><div class="page-break"></div><!-- New page -->
                        <div class="section-title break" style="font-size: 22px;">Appendix:</div>
                        <div class="content-title break" style="font-size: 18px;">4.0 Weekly Report</div><br><br><br>
                        <style>

                            .custom-table {
                                    width: 100%;
                                    border-collapse: collapse;
                                    margin-bottom: 20px;
                                }

                                .custom-table th, .custom-table td {
                                    border: 1px solid #ddd;
                                    padding: 8px;
                                    text-align: left;
                                }

                                .custom-table th {
                                    background-color: #f2f2f2;
                                }
                                .page-break {
    page-break-before: always;
}
                            </style>

                            <div class="container">
                                <h3 style="text-align: center">Appendix B Weekly Report</h3>
                                <h4>Weekly log</h4>

                                @if(count($training2) > 0)
                                    <!-- Display Trainee Name only once -->
                                    <h4 style="font-weight: normal;">Trainee Name: {{ $training2[0]->trainer }}</h4>

                                    <h4 class="underline">Description of Task/Assignment</h4>

                                    @php
                                        $taskCounter = 1;
                                    @endphp

                                    @foreach($training2 as $training)
                                        <h5 style="font-weight: normal;">Task {{ $taskCounter++ }} - {{ $training->start_date }}</h5>

                                        <div class="table-responsive">
                                            <table class="table custom-table">
                                                <thead>
                                                    <tr>
                                                        <th>Today Task</th>
                                                        <th>Obstacle Faced</th>
                                                        <th>Summary</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $training->today_task }}</td>
                                                        <td>{{ $training->obstacle_faced }}</td>
                                                        <td>{{ $training->summary }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                @else
                                    <p>No data available</p>
                                @endif
                                <br><br><br><br>

                                Signature:
                                <br><br><br>
                                Supervisor Name:
                                <br><br><br>
                                Company/Supervisor Stamp:
                                <br><br><br>
                                Date:
                                <br><br><br>
                                Remarks:
                            </div>
                            <!-- /Display -->

                        <!-- /Display -->
<!-- Monthly Report --><div class="page-break"></div><!-- New page -->
<style>
    .monthly-report {
        text-align: left;
    }

    .monthly-report-title {
        text-align: center;
    }

    .bg-white {
        overflow: hidden;
        word-wrap: break-word;
    }
    .page-break {
    page-break-before: always;
}
</style>

<div class="content-title break" style="font-size: 18px;">4.1 Monthly Report</div><br><br><br>
<div class="container">
    <h3 class="monthly-report-title">Appendix C Monthly Report</h3>

    <div class="row">
        @foreach($training3 as $training)
            <div class="col-md-12 mb-4 bg-white p-3">
                <h4 class="monthly-report">Monthly Report</h4>
                <span>Date:</span> {{ $training->start_date }}<br><br>
                <span>Trainee Name:</span> {{ $training->trainer }} <br><br><br>
                <strong>Brief description on the company's job prospectus:</strong><br><br>{{ $training->training_type }} <br><br>
                <strong>Description of tasks/assignments:</strong><br><br>{{ $training->today_task }} <br><br>
            </div>
        @endforeach
    </div>

    <br><br><br><br>

    Signature               :
    <br><br><br>
    Supervisor Name         :
    <br><br><br>
    Company/Supervisor Stamp:
    <br><br><br>
    Date                    :
    <br><br><br>
    Remarks                 :..............................................<br>
                            ...............................................<br>
                            ...............................................
</div>
<!-- /Display -->
<!-- Monthly Report --><!-- New page -->

            <!-- Print button -->
            <div class="text-right mt-2">
                <div class="dropdown dropdown-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit_training" href="#" data-toggle="modal" data-target="#edit_training"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item delete_training" href="#" data-toggle="modal" data-target="#delete_training"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        <!-- Add the download button -->
                        <!-- Print button -->
                        <button class="btn btn-primary" onclick="window.print()">Print</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- display -->

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
                        <form action="{{ route('training4/update') }}" method="POST">
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
                            <form action="{{ route('training4/delete') }}" method="POST">
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
            $('#e_students').val(_this.find('.students').text());
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

<!-- Include jQuery (if not already included) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    jQuery(document).ready(function ($) {
        // Add project header
        $("#projectContainer").on("click", ".add-project", function () {
            var projectGroup = '<div class="project-group mb-4">' +
                '<input class="form-control" type="text" name="project_headers[]" placeholder="Project Header" required>' +
                '<input class="form-control mt-2" type="text" name="project_overviews[]" placeholder="Project Overview" required>' +
                '<input class="form-control mt-2" type="text" name="problem_encountered[]" placeholder="Problem Encountered" required>' +
                '<input class="form-control mt-2" type="text" name="solutions[]" placeholder="Solutions" required>' +
                '<button class="btn btn-danger remove-project" type="button">Remove Header</button>' +
                '</div>';
            $("#projectContainer").append(projectGroup);
        });

        // Remove project header
        $(document).on("click", ".remove-project", function () {
            $(this).closest(".project-group").remove();
        });
    });
</script>

<!-- Add the following script at the end of your HTML file, after jQuery and Bootstrap scripts -->
<script>
    $(document).ready(function () {
        // Add project header and overview fields dynamically
        $('.add-project').click(function () {
            var projectGroup = $('.project-group').first().clone();
            projectGroup.find('input').val(''); // Clear input values
            projectGroup.find('.remove-project').show(); // Show remove button
            $('#projectContainer').append(projectGroup);
        });

        // Remove project header and overview fields dynamically
        $(document).on('click', '.remove-project', function () {
            $(this).closest('.project-group').remove();
        });

        // Add image upload field dynamically
        $('.add-image').click(function () {
            var imageUploadTemplate = $('.image-upload-template').first().clone();
            imageUploadTemplate.show();
            $('#imageContainer').append(imageUploadTemplate);
        });

        // Remove image upload field dynamically
        $(document).on('click', '.remove-image', function () {
            $(this).closest('.image-upload-template').remove();
        });
    });
</script>
<!--
<script>
    function exportToPdf() {
        window.location.href = "{{ route('training4/pdf') }}";
    }
</script>
-->
<style>
    /* Your regular styles go here */

    /* Hide elements in print view */
    @media print {
        .sidebar,
        .add-new-button,
        .more-vert-button,
        .page-title,
        .edit-button,
        .delete-button,
        .breadcrumb-item,
        .edit_training,
        .delete_training,
        .btn-primary,
        .modal-title,
        .modal-header,
        .print-button,
        .save-as-pdf-button {
            display: none !important;
        }
    }
</style>

<script>
    function saveAsPdf(url) {
        // Open a new window with the provided URL
        const pdfWindow = window.open(url, '_blank');

        // If the window is opened successfully, focus on it
        if (pdfWindow) {
            pdfWindow.focus();
        } else {
            // Handle cases where pop-ups are blocked
            alert('Please allow pop-ups to save as PDF.');
        }
    }
</script>

    @endsection
@endsection
