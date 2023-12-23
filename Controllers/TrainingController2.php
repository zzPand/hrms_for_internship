<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Training2;
use App\Models\User; // Make sure to include the User model
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\View;
use DB;

class TrainingController2 extends Controller
{
    // index page
    public function index()
    {
        $training2 = Training2::join('users', 'users.rec_id', '=', 'training2s.trainer_id')
            ->select('training2s.*', 'users.avatar', 'users.rec_id')
            ->get();

        $user = User::all();

        return view('training.traininglist2', compact('user', 'training2'));
    }

    // save record training
    public function addNewTraining(Request $request)
    {
        $request->validate([
            'training_type' => 'required|string|max:255',
            'obstacle_faced' => 'required|string|max:255',
            'today_task' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'summary' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $training2 = new Training2;
            $training2->fill($request->all());
            $training2->save();

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
            Training2::destroy($request->id);
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
                //'trainer',
                'obstacle_faced',
                'today_task',
                'start_date',
                'summary',
                'status',
            ]);

            Training2::where('id', $request->id)->update($update);

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
        'training2' => Training2::all(), // Change this to match your data
    ];

    $pdf = PDF::loadView('pdf.training_list_pdf', $data);

    return $pdf->download('training_list.pdf');
}
}
