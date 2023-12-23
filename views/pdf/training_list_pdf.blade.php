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
</style>

<!-- /Display -->
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
