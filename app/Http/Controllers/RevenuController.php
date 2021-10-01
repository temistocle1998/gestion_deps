<?php

namespace App\Http\Controllers;
use App\Revenu;
use App\TypeRevenu;
use App\Depense;
use Illuminate\Auth\AuthManager;
use Carbon\Carbon;


use Illuminate\Http\Request;

class RevenuController extends Controller
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
        $data = $request->validate([
            'montant' => 'required|integer',
            'type_revenu_id' => 'required|integer',
        ]);



        $revenu = Revenu::create([
            'montant' => $data['montant'],
            'type_revenu_id' => $data['type_revenu_id'],
            'user_id' => $this->auth->user()->id
        ]);

        return response()->json([
            'message' => 'revenu successfully created',
            'revenu' => $revenu
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

    /**
     * revenuActuel
     *
     * @return revenuActuel
     */
    public function revenuActuel()
    {
        $revenu = Revenu::with('user')->where('user_id', '=', $this->auth->user()->id)->whereMonth('created_at', Carbon::now()->month)->sum('montant');
        $depense = Depense::with('users')->join('depense_users', 'depense_users.user_id', '=', 'id')->where('id', '=', $this->auth->user()->id)->whereMonth('created_at', Carbon::now()->month)->sum('montant');

        $data = $revenu - $depense;

        return response()->json(['montant' => $data], 200);
    }

    public function AllRevenuByUser()
    {
        $data = Revenu::with('user')->where('user_id', '=', $this->auth->user()->id)->with('type_revenu')->get();
        

        return response()->json($data, 200);
    }

     public function revenuMois()
    {
        $revenu = Revenu::with('user')->where('user_id', '=', $this->auth->user()->id)->whereMonth('created_at', Carbon::now()->month)->sum('montant');
        return response()->json($revenu, 200);
    }

    public function getTypeRevenu()
    {
        $data = TypeRevenu::all();

        return response()->json($data, 200);
    }
   
}
