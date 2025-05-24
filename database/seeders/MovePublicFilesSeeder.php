<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;

class MovePublicFilesSeeder extends Seeder
{
    public function run(): void
    {
        $sourcePath = public_path('img/clients');
        $destinationPath = public_path('storage/banners');

        if (File::exists($destinationPath)) {
            File::deleteDirectory($destinationPath);
        }

        File::makeDirectory($destinationPath, 0755, true);

        if (File::exists($sourcePath)) {
            $files = File::files($sourcePath);

            foreach ($files as $file) {
                $fileName = $file->getFilename();

                File::copy($file, $destinationPath . '/' . $fileName);
            }
        }
    }
}
