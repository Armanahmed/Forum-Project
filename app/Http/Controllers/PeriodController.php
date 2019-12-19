<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Period;
use App\Department;
use DB;
use DateTime;
use Session;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $periods = Period::all();
        $periods = Period::all();
        $periodsstudents = DB::table('periods')
            ->join('users', 'periods.id', '=', 'users.period_id')
            ->select('periods.id as period_id', 'users.period_id as user_p_id')
            ->where('periods.id', '!=', 'users.department_id')
            ->get();
        // dd($periodsstudent);

        return view('periods.index')->withPeriods($periods)->withPeriodsstudents($periodsstudents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();

        $current_date = new DateTime();
        $date[0] = new DateTime();
        $date[1] = new DateTime();

        
        
        return view('periods.create')->withDepartments($departments)->withDate($date)->withCurrentdate($current_date);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, array(
            'period_name' => 'bail|required|min:3',
            'depts' => 'bail|required|numeric',
            'period_desc' => 'required',
            'closure_date' => 'required|date_format:Y-m-d',
            'final_date' => 'required|date_format:Y-m-d',

        ));

        $period = new Period;
        $period->period_name = $request->period_name;
        $period->period_desc = $request->period_desc;
        $period->closure_date = $request->closure_date;
        $period->final_date = $request->final_date;
        $period->department_id = $request->depts;

        $date1=date_create($request->closure_date);
        $date2=date_create($request->final_date);
        $diff=date_diff($date1,$date2);

        // dd($diff->format('%R%a'));
        if( $diff->format('%R%a') <= 0) {
            Session::flash('danger', 'Final Date should be greater than closure date !');

            return redirect()->route('periods.create');
        }

        $period->save();

        Session::flash('success', 'Successfull ! The new Session is added.');

        return redirect()->route('periods.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $period = Period::find($id);

        return view('periods.show')->withPeriod($period);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $period = Period::find($id);
        $departments = Department::all();

        $current_date = new DateTime();
        $date[0] = new DateTime();
        $date[1] = new DateTime();
        
        $depts = array();
        foreach($departments as $department) {
            $depts[$department->id] = $department->dept_name;
        }

        return view('periods.edit')->withperiod($period)->withDepts($depts)->withDate($date)->withCurrentdate($current_date);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $period = Period::find($id);        

        if($request->closure_date != null) {

            $this->validate($request, array(
                'closure_date' => 'required',
            ));

            $period->closure_date = $request->closure_date;
            
        } else {

            $period->closure_date = $period->closure_date;

        }

        if($request->final_date != null) {

            $this->validate($request, array(                    
                'final_date' => 'required',
            ));

            $period->final_date = $request->final_date;

        } else {
            $period->final_date = $period->final_date;
        }

        $date1=date_create($period->closure_date);
        $date2=date_create($period->final_date);
        $diff=date_diff($date1,$date2);

        // dd($diff->format('%R%a'));
        if( $diff->format('%R%a') <= 0) {
            Session::flash('danger', 'Final Date should be greater than closure date !');

            return redirect()->route('periods.create');
        }

        $this->validate($request, array(
            'period_name' => 'bail|required|min:3',
            'depts' => 'bail|required|numeric',
            'period_desc' => 'required',

        ));



        $period->period_name = $request->period_name;
        $period->period_desc = $request->period_desc;
        $period->department_id = $request->depts;

        $period->save();

        Session::flash('success', 'Successfull ! The new Session is edited.');

        return redirect()->route('periods.show', $period->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $period = Period::find($id);

        $period->delete();

        Session::flash('success', 'The Session was successfully deleted.');

        // $period = Department::paginate(2);

        // return view('departments.index')->withDepartments($departments);

        return redirect()->route('periods.index');
    }
}
