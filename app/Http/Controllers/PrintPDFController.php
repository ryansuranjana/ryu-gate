<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PrintPDFController extends Controller
{
    public function printStudentByClassroom(Classroom $classroom)
    {
        $students = Student::has('lateStudent')->where('classroom_id', $classroom->id)->with(['lateStudent'])->get();

        $pdf = PDF::loadview('print/student_by_classroom', [
            'classroom' => $classroom,
            'students' => $students
        ]);
        return $pdf->download('siswa-terlambat-kelas-' . $classroom->name . '-' . $classroom->major);
    }

    public function printLateStudentsByDateNow()
    {
        $lateStudent = Student::whereHas('lateStudent', fn($query) => $query->whereDate('date_late', Carbon::today()))->get();
        $pdf = PDF::loadView('print/student_late_by_date_now', [
            'date' => Carbon::today()->format('d/m/Y'),
            'students' => $lateStudent->load(['classroom', 'lateStudent' => fn($query) => $query->whereDate('date_late', Carbon::today())])
        ]);
        return $pdf->download('siswa-terlambat-' . Carbon::today()->format('d-m-Y'));
    }
}
