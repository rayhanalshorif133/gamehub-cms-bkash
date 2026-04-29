<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Prize;
use App\Models\PrizeDistribution;
use Illuminate\Support\Facades\Log;

class PrizeController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            // Prize table theke shob data distributions relationship shoho fetch kora
            $query = Prize::with('distributions')->orderBy('created_at', 'desc')->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('total_ranks', function ($prize) {
                    // Koyti rank distribution ache seta count korbe
                    return $prize->distributions->count();
                })
                ->addColumn('action', function ($row) {
                    // Edit/Delete button er jonno (optional)
                    return '
                        <button class="btn btn-sm btn-primary show-distributions" data-id="' . $row->id . '">
                            <i class="bx bx-show me-1"></i> Show
                        </button>
                        <button class="btn btn-sm btn-info edit-btn" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Delete</button>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('prize.index');
    }

    public function fetch($id)
    {
        try {
            // Prize er sathe distributions load korbe
            $prize = Prize::with('distributions')->findOrFail($id);

            return response()->json($prize);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Prize not found'], 404);
        }
    }

    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'title'         => 'required|string|max:255',
            'total_amount'  => 'required|numeric|min:0',
            'description'   => 'nullable|string',
            'rank_min'      => 'required|array',
            'rank_min.*'    => 'required|integer|min:1',
            'rank_max'      => 'required|array',
            'rank_max.*'    => 'required|integer|min:1',
            'amount'        => 'required|array',
            'amount.*'      => 'required|numeric|min:0',
            'prize_label'   => 'required|array',
            'prize_label.*' => 'required|string|max:100',
        ]);

        try {
            // 2. Start Database Transaction
            DB::beginTransaction();

            // 3. Save Master Prize Info
            $prize = new Prize();
            $prize->title = $request->title;
            $prize->total_amount = $request->total_amount;
            $prize->description = $request->description;
            $prize->save();

            // 4. Save Distributions (Dynamic Rows)
            foreach ($request->rank_min as $index => $rankMin) {
                $distribution = new PrizeDistribution();
                $distribution->prize_id = $prize->id;
                $distribution->rank_min = $rankMin;
                $distribution->rank_max = $request->rank_max[$index];
                $distribution->amount   = $request->amount[$index];
                $distribution->prize_label = $request->prize_label[$index];
                $distribution->save();
            }

            // 5. Commit Transaction
            DB::commit();

            Session::flash('success', 'Prize Pool and Distributions created successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            // Error hole shob rollback hobe
            DB::rollback();
            Log::error("Prize Store Error: " . $e->getMessage());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }





    public function create(Request $request)
    {
        try {


            dd($request->all());
            /* 
            "game_id" => "5"
  "name" => "Stick Monkey"
  "start_date_time" => "2026-04-06T10:01"
  "end_date_time" => "2026-04-20T22:00"
  "amount" => "10"
            */

            Session::flash('success', 'Campaign created successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            Session::flash('error', 'Something went wrong');
            return redirect()->back();
        }
    }
}
