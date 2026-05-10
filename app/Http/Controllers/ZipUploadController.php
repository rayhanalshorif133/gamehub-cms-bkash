<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ZipUploadController extends Controller
{

    public function index()
    {
        return view('game.game-dev.upload');
    }


    public function uploadAndUnzip(Request $request)
    {
        $request->validate([
            'zip_file' => 'required|mimes:zip|max:50000', // ৫০ এমবি পর্যন্ত
        ]);

        if ($request->hasFile('zip_file')) {
            $file = $request->file('zip_file');

            $fileName = $file->getClientOriginalName();
            $folderName = pathinfo($fileName, PATHINFO_FILENAME);

            // এটি আপনার মূল পাথ (সার্ভার পাথ)
            $destinationPath = public_path('game-dev/' . $folderName);

            // এটি ব্রাউজারে দেখার জন্য ইউআরএল পাথ
            $urlPath = asset('game-dev/' . $folderName . '/');

            if (File::exists($destinationPath)) {
                File::deleteDirectory($destinationPath);
            }
            File::makeDirectory($destinationPath, 0755, true);

            $tempZipPath = public_path('game-dev/' . $fileName);
            $file->move(public_path('game-dev'), $fileName);

            $libPath = app_path('Library/PclZip.php');

            if (file_exists($libPath)) {
                require_once $libPath;
            } else {
                return back()->with('error', 'লাইব্রেরি ফাইলটি পাওয়া যায়নি। দয়া করে app/Library ফোল্ডারে PclZip.php ফাইলটি আপলোড করুন।');
            }

            $zip = new \PclZip($tempZipPath);

            $list = $zip->listContent();

            if ($list != 0) {
                $internalFolderName = $list[0]['filename'];
                $urlPath .= '/' . $internalFolderName;
            }

            if ($zip->extract(PCLZIP_OPT_PATH, $destinationPath) != 0) {
                if (File::exists($tempZipPath)) {
                    File::delete($tempZipPath);
                }

                return back()->with('success', "সফলভাবে '$folderName' ফোল্ডারে আনজিপ হয়েছে। আপনার Path: <a href='$urlPath' target='_blank'>$urlPath</a>");
            } else {
                return back()->with('error', 'জিপ ফাইলটি প্রসেস করা যায়নি: ' . $zip->errorInfo(true));
            }
        }
    }
}
