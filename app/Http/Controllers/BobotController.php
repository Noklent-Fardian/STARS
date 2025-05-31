<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use Illuminate\Http\Request;

class BobotController extends Controller
{
    public function index()
    {
        $bobots = Bobot::all();
        return view('admin.kelolaBobot.index', compact('bobots'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'bobot.*' => 'required|numeric|min:0|max:1',
        ]);

        $total = array_sum($validated['bobot']);
        if (round($total, 2) !== 1.00) {
            if ($request->ajax()) {
                return response()->json(['errors' => ['total' => ['Total bobot harus 1.']]], 422);
            }
            return redirect()->back()->withErrors(['total' => 'Total bobot harus 1.']);
        }

        foreach ($validated['bobot'] as $id => $value) {
            Bobot::where('id', $id)->update(['bobot' => $value]);
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Bobot berhasil diperbarui.']);
        }

        return redirect()->back()->with('success', 'Bobot berhasil diperbarui.');
    }
}