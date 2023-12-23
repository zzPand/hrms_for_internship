<!-- /Display -->
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
</style>

<div class="container">
    <h2 class="monthly-report-title">Appendix C Monthly Report</h2>

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
