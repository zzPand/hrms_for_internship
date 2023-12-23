<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Training2;
use App\Models\Training3;
use App\Models\Training4;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\View;
use App\Models\User; // Make sure to include the User model

class TrainingController4 extends Controller
{
    // index page
    public function index()
    {
        $training4 = Training4::join('users', 'users.rec_id', '=', 'training4s.trainer_id')
            ->select('training4s.*', 'users.avatar', 'users.rec_id')
            ->get();

        $user = User::all();

            // Fetch data from TrainingController2
    $training2 = Training2::join('users', 'users.rec_id', '=', 'training2s.trainer_id')
    ->select('training2s.*', 'users.avatar', 'users.rec_id')
    ->get();

// Fetch data from TrainingController3
$training3 = Training3::join('users', 'users.rec_id', '=', 'training3s.trainer_id')
    ->select('training3s.*', 'users.avatar', 'users.rec_id')
    ->get();

        return view('training.traininglist4', compact('user', 'training4', 'training2', 'training3'));
    }

    // save record training
    public function addNewTraining(Request $request)
    {
        $request->validate([
            'training_type' => 'required|string|max:8000',
            'students' => 'required|string|max:255',
            'trainer' => 'required|string|max:255',
            'project_overviews.*' => 'required|string|max:8000',
            'problem_encountered.*' => 'required|string|max:8000',
            'project_headers' => 'required|array|min:1', // Ensure at least one header is provided
            'solutions.*' => 'required|string|max:8000',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Allow only image files up to 2MB
            'conclusion' => 'required|string|max:8000',
            'status' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $training4 = new Training4;
            $training4->fill($request->all());
            $training4->today_tasks = collect($request->project_headers)->map(function ($header, $index) use ($request) {
                return [
                    'header' => $header,
                    'overview' => $request->project_overviews[$index],
                    'problem' => $request->problem_encountered[$index],
                    'solution' => $request->solutions[$index],
                ];
            })->toArray();
            $training4->save();

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/images');
                    $training4->images()->create(['image_path' => basename($path)]);
                }
            }

            DB::commit();
            Toastr::success('Create new Training successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Add Training fail: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    // delete record
    public function deleteTraining(Request $request)
    {
        try {
            Training4::destroy($request->id);
            Toastr::success('Training deleted successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Training delete fail :)', 'Error');
            return redirect()->back();
        }
    }

    // update record
    public function updateTraining(Request $request)
    {
        DB::beginTransaction();

        try {
            $update = $request->only([
                'trainer_id',
                'employees_id',
                'training_type',
                'trainer',
                'students',
                'conclusion',
                'status',
            ]);

            $update['today_tasks'] = collect($request->project_headers)->map(function ($header, $index) use ($request) {
                return [
                    'header' => $header,
                    'overview' => $request->project_overviews[$index],
                    'problem' => $request->problem_encountered[$index],
                    'solution' => $request->solutions[$index],
                ];
            })->toArray();

            $request->validate([
                'training_type' => 'required|string|max:255',
                'students' => 'required|string|max:255',
                'trainer' => 'required|string|max:255',
                'project_overviews.*' => 'required|string|max:255',
                'problem_encountered.*' => 'required|string|max:255',
                'project_headers' => 'required|array|min:1', // Ensure at least one header is provided
                'solutions.*' => 'required|string|max:255',
                'conclusion' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Allow only image files up to 2MB
            ]);

            $training = Training4::findOrFail($request->id);
            $training->update($update);

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/images');
                    $training->images()->create(['image_path' => basename($path)]);
                }
            }

            DB::commit();

            // Generate and download the PDF
            $pdf = $this->exportToPdf($request->id);

            // Display a success message (optional)
            Toastr::success('Updated Training successfully :)', 'Success');

            // Return the PDF response
            return $pdf;
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Update Training fail :)', 'Error');
            return redirect()->back();
        }
    }


    public function exportPdf()
    {
        try {
            // Customize this part based on how you retrieve your training data
            $training = Training4::first(); // Change this based on your actual logic

            $htmlContent = View::make('training.traininglist4', compact('training'))->render();

            $pdf = PDF::loadHtml($htmlContent);

            // Generate the PDF content
            $pdfContent = $pdf->output();

            // Use response()->streamDownload() to force the download
            return response()->streamDownload(
                fn () => print($pdfContent),
                'training_report.pdf'
            );
        } catch (\Exception $e) {
            // Handle the exception (e.g., show an error message)
            return redirect()->back()->withErrors(['error' => 'Error generating PDF']);
        }
    }

}
