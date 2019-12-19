<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\StaffEmail;
use App\User;
use App\Period;
use App\Department;
use DB;


use Session;
use Hash;
use Input;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $staffs = DB::table('users')
            ->join('departments_users', 'users.id', '=', 'departments_users.user_id')
            ->join('departments', 'departments_users.department_id', '=', 'departments.id')
            ->select('users.*', 'departments.dept_name')
            ->where('users.role', '=', 'staff')
            ->get();

        return view('staffs.index')->withStaffs($staffs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        return view('staffs.create')->withDepartments($departments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'department_id' => 'bail|required|numeric',
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

        $staff = new User();
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->role = 'staff';
        $staff->password = Hash::make($password);
        if($staff->save() ){
            DB::table('departments_users')->insert(
                ['department_id' => $request->department_id, 'user_id' => $staff->id]
            );
            $data = array(
                'email' => $staff->email,
                'subject' => "Idea Forum Account Info",
                'bodyMessage' => "Please save this info for your account.",
                'password' => $password
            );
            Mail::to($data['email'])->send(new StaffEmail($data));

            Session::flash('success', 'Staff user added successfully.');
            return redirect()->route('staffs.index');
        } else {
            Session::flash('danger', 'Sorry a problem occured while creating staff.');
            return redirect()->route('staffs.create');
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
        $staff = DB::table('users')
            ->join('departments_users', 'users.id', '=', 'departments_users.user_id')
            ->join('departments', 'departments_users.department_id', '=', 'departments.id')
            ->select('users.*', 'departments.dept_name')
            ->where('users.id', '=', $id)
            ->first();
        return view('staffs.show')->withstaff($staff);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $departments = Department::all();
        $staff = DB::table('users')
            ->join('departments_users', 'users.id', '=', 'departments_users.user_id')
            ->join('departments', 'departments_users.department_id', '=', 'departments.id')
            ->select('users.*', 'departments_users.department_id', 'departments.dept_name')
            ->where('users.id', '=', $id)
            ->first();
        return view('staffs.edit')->withStaff($staff)->withDepartments($departments);
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
        $staff = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'department_id' => 'bail|required|numeric',
            'role' => 'required'
        ]);

        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->role = 'staff';

        if($request->auto_generate == 'on'){

            

        } else {
            $this->validate($request, [
                'password' => 'bail|required|min:6'
            ]);
            $password = trim($request->password);
            $staff->password = Hash::make($password);
        }        
        
        // $staff->password = Hash::make($password);

        if($staff->save() ){

            DB::table('departments_users')
            ->where('user_id', $id)
            ->update(['department_id' => $request->department_id]);
            Session::flash('success', 'Staff Information updated successfully.');
            return redirect()->route('staffs.show', $staff->id);
        } else {
            Session::flash('danger', 'Sorry a problem occured while creating staff.');
            return redirect()->route('staffs.create');
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
        $staff = User::find($id);

        $staff->delete();

        DB::table('comments')
            ->where('user_id', $id)
            ->delete();

        DB::table('likes')
            ->where('user_id', $id)
            ->delete();

        DB::table('departments_users')
            ->where('user_id', $id)
            ->delete();

        Session::flash('success', 'The Staff is successfully removed.');

        return redirect()->route('staffs.index');
    }
}
