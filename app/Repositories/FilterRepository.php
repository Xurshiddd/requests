<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FilterRepository extends Controller
{
    public function bugungi(Request $request)
    {
        $requests = DB::table('requests')
            ->leftJoin('kafedras', 'requests.kafedra_id', '=', 'kafedras.id')
            ->whereDate('requests.created_at', '=', today())
            ->select('requests.*', 'kafedras.name as name')
            ->latest('requests.created_at') // specify the table for sorting
            ->get();

        return view('requests.index', ['requests' => $requests]);
    }

    public function bajarilmagani(Request $request)
    {
        $requests = DB::table('requests')
            ->leftJoin('kafedras', 'requests.kafedra_id', '=', 'kafedras.id')
            ->where('requests.status', '=', 'new')
            ->select('requests.*', 'kafedras.name as name')
            ->latest('requests.created_at')
            ->get();

        return view('requests.index', ['requests' => $requests]);
    }

    public function changeStatus(Request $request)
    {
        try {
            DB::table('requests')->where('id', $request->id)->update(['status' => $request->status]);
            return response()->json([
                'success' => true,
                'message' => 'Request status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
