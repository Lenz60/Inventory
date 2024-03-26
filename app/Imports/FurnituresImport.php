<?php

namespace App\Imports;

use App\Models\Furniture;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class FurnituresImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $excel_file = public_path('storage/excel/jpyziLYmnjRxTDXscRmDBRTKxdffnwDQ7kuajCsO.xlsx');


        $reader = new Xlsx();
        $spreadsheet = $reader->load($excel_file);
        // $spreadsheet->getSheet(0);
        $sheet = $spreadsheet->getActiveSheet();

        $drawings = $sheet->getDrawingCollection();

        dd($row);

        // foreach ($drawings as $drawing){
        //         $coordinates = $drawing->getCoordinates();
        //         $drawing_path = $drawing->getPath();
        //         $extension = pathinfo($drawing_path, PATHINFO_EXTENSION);

        //         $img_url = "/storage/furniture-img/{$coordinates}.{$extension}";
        //         $img_path = public_path($img_url);


        //         $contents = file_get_contents($drawing_path);
        //         file_put_contents($img_path, $contents);
        //         // echo $coordinates . '';
        //         // echo $drawing_path . '';
        //         // echo '<br>';
        //         // dd($img_path);
        //     }

        return new Furniture([
            //
            // (foreach ($drawings as $drawing){
            //     $coordinates = $drawing->getCoordinates();
            //     $drawing_path = $drawing->getPath();
            //     $extension = pathinfo($drawing_path, PATHINFO_EXTENSION);

            //     $img_url = "/storage/furniture-img/{$coordinates}.{$extension}";
            //     $img_path = public_path($img_url);


            //     $contents = file_get_contents($drawing_path);
            //     file_put_contents($img_path, $contents);
            //     // echo $coordinates . '';
            //     // echo $drawing_path . '';
            //     // echo '<br>';
            //     // dd($img_path);
            //     'image' = $img_url;
            // }),

            'uuid' => fake()->uuid(),
            'image' => $row[1],
            'code' => $row[2],
            'description' => $row[3],
            'category' => $row[4],
            'wood_type' => $row[5],
            'width' => $row[6],
            'depth' => $row[7],
            'height' => $row[8],
            'stock' => $row[9],
            'price' => $row[10],
        ]);
    }
}
