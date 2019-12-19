<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\CoordinatorEmail;
use App\User;
use App\Period;
use App\Department;
use DB;


use Session;
use Hash;
use Input;

class CoordinatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $coordinators = DB::table('users')
            ->join('departments', 'users.id', '=', 'departments.coordinator_id')
            ->select('users.*', 'departments.dept_name', 'departments.coordinator_id')
            ->get();

        return view('coordinators.index')->withCoordinators($coordinators);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        return view('coordinators.create')->withDepartments($departments);
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

        $coordinator = new User();
        $coordinator->name = $request->name;
        $coordinator->email = $request->email;
        $coordinator->role = 'coordinator';
        $coordinator->password = Hash::make($password);
        if($coordinator->save() ){
            DB::table('departments')
                ->where('id', $request->department_id)
                ->update(['coordinator_id' => $coordinator->id ]);
            
            return redirect()->route('coordinators.index');
        } else {
            Session::flash('danger', 'Sorry a problem occured while creating coordinator.');
            return redirect()->route('coordinators.create');
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
        $coordinator = DB::table('users')
            ->join('departments', 'users.id', '=', 'departments.coordinator_id')
            ->select('users.*', 'departments.dept_name', 'departments.coordinator_id')
            ->where('users.id', '=', $id)
            ->first();
        return view('coordinators.show')->withCoordinator($coordinator);
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
        $coordinator = DB::table('users')
            ->join('departments', 'users.id', '=', 'departments.coordinator_id')
            ->select('users.*', 'departments.dept_name', 'departments.coordinator_id')
            ->where('users.id', '=', $id)
            ->first();

        // dd($coordinator);
        return view('coordinators.edit')->withCoordinator($coordinator)->withDepartments($departments);
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
        $coordinator = User::findOrFail($id);
        
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            // 'department_id' => 'bail|required|numeric',
            'role' => 'required'
        ]);

        // if( !empty($request->password )){
        //     $password = trim($request->password);
        //     $coordinator->password = Hash::make($password);
        // } else {
        //     $length = 10;
        //     $keyspace = '123456789abcdefghijkmnpqrstuvexyzABCDEFGHJKLMNPQRSTUVWXYZ';
        //     $str = '';
        //     $max = mb_strlen($keyspace, '8bit') - 1;
        //     for($i = 0; $i < $length; $i++) {
        //         $str .= $keyspace[random_int(0, $max)];
        //     }
        //     $password = $str;
        // }

        
        $coordinator->name = $request->name;
        $coordinator->email = $request->email;
        $coordinator->role = 'coordinator';

        if($request->auto_generate == 'on'){

            

        } else {
            $this->validate($request, [
                'password' => 'bail|required|min:6'
            ]);
            $password = trim($request->password);
            $coordinator->password = Hash::make($password);
        }        
        
        

        if($coordinator->save() ){

            // DB::table('departments')
            //     ->where('id', $request->department_id)
            //     ->update(['coordinator_id' => $coordinator->id ]);
            Session::flash('success', 'Successfully updated the user info.');
            return redirect()->route('coordinators.index');
        } else {
            Session::flash('danger', 'Sorry a problem occured while creating user.');
            return redirect()->route('coordinators.create');
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

        Session::flash('success', 'The Staff is successfully removed.');

        return redirect()->route('staffs.index');
    }
}
