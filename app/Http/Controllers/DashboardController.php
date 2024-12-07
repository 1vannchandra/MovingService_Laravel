<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Dompdf\Options;
use Dompdf\Dompdf;

class DashboardController extends Controller
{
    public function index()
    {
        // $userId = Session::get('id');
        $userId = Auth::id();
        $user = DB::table('pengguna')->where('id', $userId)->first();

        $totalPengguna = DB::table('pengguna')->count();
        $totalLayanan = DB::table('layanan')->count();
        $totalInputPelayanan = DB::table('input_pelayanan')->count();

        return view('dashboard', [
            'user' => $user,
            'totalPengguna' => $totalPengguna,
            'totalLayanan' => $totalLayanan,
            'totalInputPelayanan' => $totalInputPelayanan
        ]);
    }

    public function updateProfile(Request $request)
    {

        DB::table('pengguna')
            ->where('id', $request->input('id'))
            ->update([
                'nama' => $request->input('nama'),
                'email' => $request->input('email'),
                'no_telepon' => $request->input('no_telepon'),
                'alamat' => $request->input('alamat'),
            ]);

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
    }

    public function indexService()
    {
        return view('dashboard-service');
    }

    public function createService(Request $request)
    {
        $pengguna_id = Auth::id();

        try {
            // Menyimpan data ke tabel layanan
            $layanan_id = DB::table('layanan')->insertGetId([
                'nama_layanan' => $request->input('nama_layanan'),
                'deskripsi' => $request->input('deskripsi'),
            ]);

            DB::table('input_pelayanan')->insert([
                'pengguna_id' => $pengguna_id,
                'layanan_id' => $layanan_id,
                'tanggal_permintaan' => $request->input('tanggal_permintaan'),
                'status' => $request->input('status'),
            ]);

            return redirect()->route('dashboard-service')->with('success', 'Pelayanan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function indexEdit()
    {
        $requests = DB::table('input_pelayanan')
            ->join('layanan', 'input_pelayanan.layanan_id', '=', 'layanan.id')
            ->select(
                'input_pelayanan.id as request_id',
                'layanan.nama_layanan',
                'layanan.deskripsi',
                'input_pelayanan.tanggal_permintaan',
                'input_pelayanan.status'
            )
            ->orderBy('input_pelayanan.tanggal_permintaan', 'desc')
            ->get();

        return view('dashboard-edit', compact('requests'));
    }


    public function updateEdit(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'status' => 'required|string|in:Pending,Confirmed,Completed',
        ]);

        DB::transaction(function () use ($validated) {
            DB::table('input_pelayanan')->where('id', $validated['id'])->update([
                'tanggal_permintaan' => $validated['tanggal'],
                'status' => $validated['status'],
            ]);

            DB::table('layanan')
                ->where('id', function ($query) use ($validated) {
                    $query->select('layanan_id')
                        ->from('input_pelayanan')
                        ->where('id', $validated['id']);
                })
                ->update([
                    'nama_layanan' => $validated['nama'],
                    'deskripsi' => $validated['deskripsi'],
                ]);
        });

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
    }

    public function updateDelete(Request $request)
    {
        $request->validate(['id' => 'required|integer']);

        DB::table('input_pelayanan')->where('id', $request->id)->delete();

        return response()->json(['success' => true, 'message' => 'Record deleted successfully']);
    }

    public function indexPrint()
    {
        return view('dashboard-print');
    }

    public function printProcess()
    {
        $data = DB::table('pengguna')
            ->join('input_pelayanan', 'pengguna.id', '=', 'input_pelayanan.pengguna_id')
            ->join('layanan', 'layanan.id', '=', 'input_pelayanan.layanan_id')
            ->select('pengguna.*', 'layanan.*', 'input_pelayanan.*')
            ->get();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        $html = '<h1 style="text-align: center;">Service Data</h1>';
        $html .= '<table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse;">';
        $html .= '<tr><th style="background-color: #f2f2f2; padding: 8px;">Nama</th><th style="background-color: #f2f2f2; padding: 8px;">Nama Layanan</th><th style="background-color: #f2f2f2; padding: 8px;">Deskripsi</th><th style="background-color: #f2f2f2; padding: 8px;">Tanggal Permintaan</th></tr>';

        foreach ($data as $row) {
            $html .= '<tr>';
            $html .= '<td style="padding: 8px;">' . htmlspecialchars($row->nama) . '</td>';
            $html .= '<td style="padding: 8px;">' . htmlspecialchars($row->nama_layanan) . '</td>';
            $html .= '<td style="padding: 8px;">' . htmlspecialchars($row->deskripsi) . '</td>';
            $html .= '<td style="padding: 8px;">' . htmlspecialchars($row->tanggal_permintaan) . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("service_data.pdf", array("Attachment" => 1));

        return redirect()->route('dashboard-print');
    }
}
