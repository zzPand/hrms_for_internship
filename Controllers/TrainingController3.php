<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Training3;
use App\Models\User; // Make sure to include the User model
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\View;
use DB;

class TrainingController3 extends Controller
{
    // index page
    public function index()
    {
        $training3 = Training3::join('users', 'users.rec_id', '=', 'training3s.trainer_id')
            ->select('training3s.*', 'users.avatar', 'users.rec_id')
            ->get();

        $user = User::all();

        return view('training.traininglist3', compact('user', 'training3'));
    }

    // save record training
    public function addNewTraining(Request $request)
    {
        $request->validate([
            'training_type' => 'required|string|max:8000',
            'trainer' => 'required|string|max:255',
            'today_task' => 'required|string|max:8000',
            'start_date' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $training3 = new Training3;
            $training3->fill($request->all());
            $training3->save();

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
            Training3::destroy($request->id);
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
                'today_task',
                'start_date',
                'status',
            ]);

            Training3::where('id', $request->id)->update($update);

            DB::commit();
            Toastr::success('Updated Training successfully :)', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Update Training fail :)', 'Error');
            return redirect()->back();
        }
    }

    public function exportPdf()
{
    $data = [
        'training3' => Training3::all(), // Change this to match your data
    ];

    $pdf = PDF::loadView('pdf.training_list_pdf2', $data);

    return $pdf->download('training_list.pdf');
}
}
