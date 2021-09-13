<?php

namespace App\Http\Controllers;

use App\Depense;
use App\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

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

        return response()->json($data, 200);;
    }
}
