<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\CoordinatorEmail;
use Illuminate\Database\Eloquent\Collection;
use App\Department;
use App\User;
use Session;
use DB;
use Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $departments = Department::paginate(2);
        $depts = DB::table('departments')
            ->join('users', 'departments.coordinator_id', '=', 'users.id')
            ->select('departments.*', 'users.name', 'users.id as user_id')
            ->where('departments.disabled', '<', '1')
            ->get();

        $deptperiods = DB::table('departments')
            ->join('periods', 'departments.id', '=', 'periods.department_id')
            ->select('departments.id as dept_id', 'periods.id as period_id')
            ->where('departments.id', '!=', 'periods.department_id')
            ->get();
        // dd($deptperiods);

        // $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // $col = new Collection($depts);
        // $perPage = 5;
        // $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        // $departments = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

        // $departments = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage, $currentPage,['path' => url('departments/')] );

        // dd($departments);

        return view('departments.index')->withDepartments($depts)->withDeptperiods($deptperiods);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staffs = DB::table('users')
            ->select('users.*')
            ->where('users.role', '=', 'staff')
            ->get();
        // $departments = Department::all();
        return view('departments.create')->withStaffs($staffs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->coordinator_input){

            $this->validate($request, [
                'dept_name' => 'bail|required|min:3|unique:departments,dept_name',
                'dept_detail' => 'bail|required',
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'role' => 'required'
            ]);

            if( !empty($request->password )){
                $password = trim($request->password);
            } else {
                $length = 10;
                $keyspace = '123456789abcdefghijkmnpqrstuvexyzABCDEFGHJKLMNPQRSTUVWXYZ';
                $str = '';
                $max = mb_strlen($keyspace, '8bit') - 1;
                for($i = 0; $i < $length; $i++) {
                    $str .= $keyspace[random_int(0, $max)];
                }
                $password = $str;
            }

            $coordinator = new User();
            $coordinator->name = $request->name;
            $coordinator->email = $request->email;
            $coordinator->role = 'coordinator';
            $coordinator->password = Hash::make($password);

            $department = new Department;
            $department->dept_name = $request->dept_name;
            $department->dept_detail = $request->dept_detail;

            if($coordinator->save()) {
                $department->save();

                DB::table('departments')
                ->where('id', $department->id)
                ->update(['coordinator_id' => $coordinator->id ]);

                DB::table('departments_users')->insert(
                    ['department_id' => $department->id, 'user_id' => $coordinator->id]
                );

                $data = array(
                    'email' => $coordinator->email,
                    'subject' => "Idea Forum Account Info",
                    'bodyMessage' => "Please save this info for your account.",
                    'password' => $password
                );
                Mail::to($data['email'])->send(new CoordinatorEmail($data));

                Session::flash('success', 'Successfull ! The new department is added to the list.');

                return redirect()->route('departments.index');
            } else {
                Session::flash('danger', 'Sorry a problem occured while creating staff.');
                return redirect()->route('departments.create');
            }

        } else {

            $this->validate($request, array(
                'dept_name' => 'bail|required|min:3|unique:departments,dept_name',
                'dept_detail' => 'bail|required',
                'coordinator_id' => 'bail|required|numeric',

            ));

            $department = new Department;
            $department->dept_name = $request->dept_name;
            $department->dept_detail = $request->dept_detail;
            $department->coordinator_id = $request->coordinator_id;

            if($department->save()) {
                DB::table('users')
                ->where('id', $request->coordinator_id)
                ->update(['role' => 'coordinator' ]);



                DB::table('departments_users')->insert(
                    ['department_id' => $department->id, 'user_id' => $request->coordinator_id]
                );

                Session::flash('success', 'Successfull ! The new department is added to the list.');
                return redirect()->route('departments.index');
            } else {
                Session::flash('danger', 'Sorry a problem occured while creating department.');
                return redirect()->route('departments.create');
            }

        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $department = Department::find($id);
        $department = DB::table('departments')
            ->join('users', 'departments.coordinator_id', '=', 'users.id')
            ->select('departments.*', 'users.name', 'users.id as user_id')
            ->where('departments.id', '=', $id)
            ->first();
        // dd($department);
        return view('departments.show')->withDepartment($department);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = DB::table('departments')
            ->join('users', 'departments.coordinator_id', '=', 'users.id')
            ->select('departments.*', 'users.name', 'users.id as user_id', 'users.email')
            ->where('departments.id', '=', $id)
            ->first();
        $staffs = DB::table('users')
            ->select('users.*')
            ->where('users.role', '=', 'staff')
            ->get();

        return view('departments.edit')->withDepartment($department)->withStaffs($staffs);
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
        $department = Department::find($id);


        if($department->dept_name == $request->dept_name){
            $this->validate($request, array(
                'dept_detail' => 'bail|required'
            ));
        } else {
            $this->validate($request, array(
                'dept_name' => 'bail|required|min:3|unique:departments,dept_name',
                'dept_detail' => 'bail|required'
            ));
        }
        

        $oldcoordinator = $department->coordinator_id;

        if($request->coordinator_input){
            $this->validate($request, array(
                'coordinator_id' => 'bail|required|numeric'
            ));
            $department->coordinator_id = $request->coordinator_id;
        }
        

        $department->dept_name = $request->dept_name;
        $department->dept_detail = $request->dept_detail;

        if($department->save()) {
            if($request->coordinator_id){

                DB::table('users')
                    ->where('id', $request->coordinator_id)
                    ->update(['role' => 'coordinator' ]);

                DB::table('users')
                    ->where('id', $oldcoordinator)
                    ->update(['role' => 'staff' ]);

                DB::table('departments_users')
                    ->where('user_id', $request->coordinator_id)
                    ->update(['user_id' => $oldcoordinator]);

            }
            Session::flash('success', 'Successfull ! The department is edited.');

            return redirect()->route('departments.show', $department->id);
            
        } else {
            Session::flash('danger', 'Sorry a problem occured while updating department.');
            return redirect()->route('departments.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::find($id);

        // DB::table('departments')
        //     ->where('id', $department->id)
        //     ->update(['disabled' => '1' ]);
        DB::table('users')
            ->where('id', $department->coordinator_id)
            ->delete();
            
        DB::table('departments')
            ->where('id', $id)
            ->delete();

        

        Session::flash('danger', 'The departments is successfully disabled.');

        // return view('departments.index')->withDepartments($departments);

        return redirect()->route('departments.index');
    }
}
