<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function index()
    {
        $requests = DB::table('requests')
            ->leftJoin('kafedras', 'kafedras.id', '=', 'requests.kafedra_id')
            ->join('users', 'users.id', '=', 'requests.from')
            ->select('requests.*', 'kafedras.name as name', 'users.name as user')
            ->latest()
            ->get();
        return view('requests.index', compact( 'requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'kafedra_id' => 'required|integer',
                'description' => 'required|string',
                'room' => 'required|integer',
                'floor' => 'required|integer|between:1,6',
                'building' => 'required|integer|between:1,5',
            ]);
            DB::table('requests')->insert([
                'from' => Auth::id(),
                'kafedra_id' => $request->kafedra_id,
                'description' => $request->description,
                'room' => $request->room,
                'floor' => $request->floor,
                'building' => $request->building,
                'status' => 'new',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return redirect()->route('dashboard')->with('success', 'So\'rovnoma muvofaqiyatli jo\'natildi');
        }catch (\Exception $exception){
            return redirect()->route('dashboard')->with('errors', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('requests')->where('id', $id)->delete();
        return back()->with('success', 'Request has been deleted');
    }
}
