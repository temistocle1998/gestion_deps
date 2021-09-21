<?php

namespace App\Http\Controllers;

use App\Depense;
use App\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepenseController extends Controller
{
    /**
    * @var AuthManager;
    */
    private $auth;

    public function __construct(AuthManager $auth)
    {
        $this->middleware('auth:api');
        $this->auth = $auth;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'description' => 'required|string|between:3,100',
            'montant' => 'required|integer',
            'categorie_id' => 'required|integer'
        ]);

        $user = User::find($this->auth->user()->id);

        $depense = Depense::create($validator);
        $this->auth->user()->depenses()->attach($depense);

        return response()->json([
            'message' => 'depense successfully created',
            'depense' => $depense
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getDepenseByUser()
    {
        $data = User::with('depenses')->where('id', '=' ,  $this->auth->user()->id)->get();
        // $data = Depense::with('categorie')->join('depense_users', 'depense_users.user_id', '=', 'depense_users.user_id')
        // ->where('depense_users.user_id', '=', $this->auth->user()->id)
        // ->select('depenses.id', 'depenses.description', 'depenses.montant', 'depenses.date', 'depenses.categorie_id')->get();
        // $data = DB::select('SELECT depenses.montant FROM depenses JOIN depense_users WHERE depense_users.user_id = :user_id',['user_id' => $this->auth->user()->id]);
        // $data = DB::table('depenses')->join('depense_users', 'depense_users.user_id', '=', 'user_id')->where('user_id', '=', '1')->get();

        return response()->json($data, 200);
    }

    public function getDepenseByMonth($month)
    {
        $data = Depense::whereRaw('MONTH(created_at) = '.$month)->get();

        return response()->json($data, 200);
    }

    public function getDepenseByDay($day)
    {
        $data = Depense::whereRaw('DAY(created_at) = '.$day)->get();

        return response()->json($data, 200);
    }

    public function getDepenseByYear($year)
    {
        $data = Depense::whereRaw('YEAR(created_at) = '.$year)->get();

        return response()->json($data, 200);
    }

    public function getTotalCurrentDepense(){
        $data = Depense::with('users')->join('depense_users', 'depense_users.user_id', '=', 'id')->where('id', '=', $this->auth->user()->id)->whereMonth('created_at', Carbon::now()->month)->sum('montant');

        return response()->json($data, 200);
    }
}
