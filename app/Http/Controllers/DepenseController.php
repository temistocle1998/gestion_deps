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
        $data= DB::SELECT("SELECT dep.depense_id, d.description, d.montant, c.nom, d.created_at
                FROM depenses d
                INNER JOIN depense_users dep
                ON  d.id = dep.depense_id
                INNER JOIN categories c ON c.id = d.categorie_id
                INNER JOIN users u ON dep.user_id=u.id WHERE u.id=?", [$this->auth->user()->id]);

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
        $data = Depense::whereRaw('YEAR(created_at) = '.$year)->join('depense_users', 'depense_users.user_id', '=', 'id')->where('id', '=', $this->auth->user()->id)->get();

        return response()->json($data, 200);
    }

    public function getTotalCurrentDepense(){
        // $mois = Carbon::now()->month;
        // $data = Depense::with('users')
        // ->join('depense_users', 'depense_users.user_id', '=', 'id')
        // ->where('id', '=', $this->auth->user()->id)
        // ->sum('montant');
        $data= DB::SELECT("SELECT SUM(d.montant) as montant
        FROM depenses d
        INNER JOIN depense_users dep
        ON d.id = dep.depense_id
        INNER JOIN users u ON dep.user_id=u.id WHERE u.id=?
        AND MONTH(d.date)=?",[$this->auth->user()->id, Carbon::now()->month]);
        // $data = DB::table('depenses')
        // ->whereMonth('created_at', Carbon::now()->month)
        // ->join('depense_users', 'depense_users.user_id', '=', 'id')
        // ->where('depense_users.user_id', '=', $this->auth->user()->id)
        // ->sum('depenses.montant');
        // $year = Carbon::now();
        // $data = Depense::whereRaw('MONTH(created_at) = '.$year->month)->join('depense_users', 'depense_users.user_id', '=', 'id')->where('id', '=', $this->auth->user()->id)->sum('montant');
        return response()->json($data[0], 200);
    }
}
