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

    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .report-table th, .report-table td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    .bold {
        font-weight: bold;
    }
</style>


<div class="container">
    <h2 class="monthly-report-title">Final Report</h2>

    <div class="row">
        @foreach($training4 as $key => $training)
            <div class="col-md-12 mb-4 bg-white p-3">
                <h4 class="monthly-report">Industrial Training</h4>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $training->students }}</td>
                            <td>{{ $training->trainer }}</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <strong class="bold">Company Background:</strong>
                <br>
                {{ $training->training_type }}
                <br><br>
                <strong>IT Related Projects/Tasks/Assignments:</strong>
                <br>
                {{ $training->today_task }} {{ $training->today_task2 }}
                <br><br>
                <strong>Project Overview</strong>
                <br>
                {{ $training->today_task }}
                <br><br>
                <strong>Problems Encountered</strong>
                <br>
                {{ $training->today_task }}
                <br><br>
                <strong>Solutions</strong>
                <br>
                {{ $training->today_task }}
                <br><br>
                <strong>Conclusion</strong>
                <br>
                {{ $training->conclusion }}
                <br><br>
            </div>
        @endforeach

                            <!-- Display Images Section -->
                            <div class="display-images">
                                @if(count($training->images) > 0)
                                    <strong>Images:</strong><br>
                                        @foreach($training->images as $image)
                                            <img src="{{ asset('storage/images/' . $image->image_path) }}" alt="Image">
                                        @endforeach
                                @endif
                            </div>

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
