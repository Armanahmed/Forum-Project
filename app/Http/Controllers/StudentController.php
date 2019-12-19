<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Mail;
use App\Mail\StudentEmail;
use App\User;
use App\Period;
use App\Department;
use App\Comment;
use App\Post;
use DB;


use Session;
use Hash;
use Input;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = DB::table('users')
            ->join('periods', 'users.period_id', '=', 'periods.id')
            ->join('departments', 'periods.department_id', '=', 'departments.id')
            ->select('users.*', 'periods.period_name', 'departments.dept_name')
            ->where('users.role', '=', 'student')
            ->get();

        return view('students.index')->withStudents($students);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periods = Period::all();
        return view('students.create')->withPeriods($periods);
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
            'period_id' => 'bail|required|numeric',
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

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->period_id = $request->period_id;
        $user->role = 'student';
        $user->password = Hash::make($password);
        if($user->save()){

            $data = array(
            'email' => $user->email,
            'subject' => "Idea Forum Account Info",
            'bodyMessage' => "Please save this info for your account.",
            'password' => $password
            );
            Mail::to($data['email'])->send(new StudentEmail($data));

            Session::flash('success', 'Student user added Successfully.');
            return redirect()->route('users.index');
        } else {
            Session::flash('danger', 'Sorry a problem occured while creating user.');
            return redirect()->route('users.create');
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
        $student = DB::table('users')
            ->join('periods', 'users.period_id', '=', 'periods.id')
            ->join('departments', 'periods.department_id', '=', 'departments.id')
            ->select('users.*', 'periods.period_name', 'periods.closure_date', 'periods.final_date', 'departments.dept_name')
            ->where('users.id', '=', $id)
            ->first();
        return view('students.show')->withStudent($student);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $periods = Period::all();
        $student = DB::table('users')
            ->join('periods', 'users.period_id', '=', 'periods.id')
            ->join('departments', 'periods.department_id', '=', 'departments.id')
            ->select('users.*', 'periods.period_name', 'periods.closure_date', 'periods.final_date', 'departments.dept_name')
            ->where('users.id', '=', $id)
            ->first();
        return view('students.edit')->withStudent($student)->withPeriods($periods);
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
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'period_id' => 'bail|required|numeric',
            'role' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->period_id = $request->period_id;
        $user->role = 'student';

        if($request->auto_generate == 'on'){

            

        } else {
            $this->validate($request, [
                'password' => 'bail|required|min:6'
            ]);
            $password = trim($request->password);
            $user->password = Hash::make($password);
        }
        // exit();

        // if( !empty($request->password )){
        //     $password = trim($request->password);
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

        
        
        
        if($user->save()){
            Session::flash('success', 'The Student Info is successfully updated.');
            return redirect()->route('users.show', $id);
        } else {
            Session::flash('danger', 'Sorry a problem occured while updating student.');
            return redirect()->route('students.create');
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
        $student = User::find($id);
        

        $student->delete();

        DB::table('comments')
            ->where('user_id', $id)
            ->delete();

        DB::table('posts')
            ->where('user_id', $id)
            ->delete();

        DB::table('likes')
            ->where('user_id', $id)
            ->delete();

        DB::table('files')
            ->where('user_id', $id)
            ->delete();

        Session::flash('danger', 'The Student is successfully removed.');

        return redirect()->route('users.index');
    }
}
