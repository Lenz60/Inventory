<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Spatie\Tags\Tag;
use App\Models\Furniture;
use Illuminate\Http\Request;
use App\Imports\FurnituresImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\InputUpdateRequest;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Symfony\Component\HttpFoundation\RedirectResponse;

class InputController extends Controller
{
    //
    public function index(Request $request){
        // $user = Auth::user();

        // dd($user);
        $furniture = DB::table('furniture')
        ->get();
        // dd($furniture[0]->image);



    return Inertia::render('Input/Input', [
        'furnitures' => $furniture,
    ]);

    }

    public function create(Request $request){



        $check = $this->validateInput($request,'input');
        // dd($check['image']);
        // dd($request->all());
        // dd($request->image->getClientOriginalName());
        // dd(fake()->uuid());
        if($check){
            if($check['image']){
                $fileUrl = $request->file('image')->store('furniture-img');
            }else {
                $fileUrl = null;
            }

            Furniture::create ([
                'uuid' => fake()->uuid(),
                'image' => $fileUrl,
                'code' => $request->code,
                'description' => $request->description,
                'category' => $request->category,
                'wood_type' => $request->woodtype,
                'width' => $request->width,
                'depth' => $request->depth,
                'height' => $request->height,
                'stock' => $request->stock,
                'price' => $request->price,
            ]);
        }
        return redirect()->back()->with('message', 'input:200');
    }

    public function update(Request $request){

        $this->validateInput($request,'update');
        return redirect()->back()->with('message', 'update:200');
        // return Redirect::route('input.index', ['message' => 'update:200']);
    }

    public function validateInput($input, $context){
        $validationInteger = "required|numeric|min:0|not_in:0";
        $validationString = "required|string";

        //To separate different error validation between input and update validation
        //pass the context to the function
        //if there is not context then it means that the validation is for update field and return different error variables
        if ($context == 'input'){
            return $input -> validate([
                    'image' => "required|image|file|max:1024",
                    'description' => $validationString,
                    'category' => $validationString,
                    'woodtype' => $validationString,
                    'width' => $validationInteger,
                    'height' => $validationInteger,
                    'depth' => $validationInteger,
                    'stock' => $validationInteger,
                    'price' => $validationInteger,
                ]);
        }else{
            return $input -> validate([
                    'sImage' => "required|image|file|max:1024",
                    'sDescription' => $validationString,
                    'sCategory' => $validationString,
                    'sWoodtype' => $validationString,
                    'sWidth' => $validationInteger,
                    'sHeight' => $validationInteger,
                    'sDepth' => $validationInteger,
                    'sStock' => $validationInteger,
                    'sPrice' => $validationInteger,
            ]);
        }
    }
    public function delete(Request $request){
        $deletedFurniture = Furniture::find($request->uuid);
        $deletedFurniture->delete();

        //create failsafe here if uuid is not valid or not exists
        //if uuid is not exists then send message that the uuid is invalid
        return redirect()->back()->with('message', 'delete:200');
    }

    public function importIndex (Request $request){

        // $excel_file = public_path('storage/excel/jpyziLYmnjRxTDXscRmDBRTKxdffnwDQ7kuajCsO.xlsx');


        // $reader = new Xlsx();
        // $spreadsheet = $reader->load($excel_file);
        // // $spreadsheet->getSheet(0);
        // $sheet = $spreadsheet->getActiveSheet();

        // $drawings = $sheet->getDrawingCollection();

        // // dd($sheet);

        // // dd($drawings);
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
        //     foreach($drawings as $drawing){
        //         dd($drawing);
        //     }




        return Inertia::render('Input/Import');
    }

    public function import (Request $request){
        // dd($request);
        if($request->file){
            $excelFile = $request->file('file');

            $fileName = $excelFile->getClientOriginalName();
            $excelFile->move('FurnitureData', $fileName);

            $excelUrl = public_path('/FurnitureData/'.$fileName);

            $reader = new Xlsx();
            $spreadsheet = $reader->load($excelUrl);

            $sheet = $spreadsheet->getActiveSheet();
            $drawings = $sheet->getDrawingCollection();

            $cells = $sheet->getCellCollection();

            // dd($cells->getHighestRow());

            for($row = 1; $row <= $cells->getHighestRow(); $row++){
                $array[$row]['uuid'] = fake()->uuid();
                $array[$row]['image'] = ($cells->get('B'.$row)) ? $cells->get('B'.$row)->getValue():'';
                $array[$row]['code'] = ($cells->get('C'.$row)) ? $cells->get('C'.$row)->getValue():'';
                $array[$row]['description'] = ($cells->get('D'.$row)) ? $cells->get('D'.$row)->getValue():'';
                $array[$row]['category'] = ($cells->get('E'.$row)) ? $cells->get('E'.$row)->getValue():'';
                $array[$row]['wood_type'] = ($cells->get('F'.$row)) ? $cells->get('F'.$row)->getValue():'';
                $array[$row]['width'] = ($cells->get('G'.$row)) ? $cells->get('G'.$row)->getValue():'';
                $array[$row]['depth'] = ($cells->get('H'.$row)) ? $cells->get('H'.$row)->getValue():'';
                $array[$row]['height'] = ($cells->get('I'.$row)) ? $cells->get('I'.$row)->getValue():'';
                $array[$row]['stock'] = ($cells->get('J'.$row)) ? $cells->get('J'.$row)->getValue():'';
                $array[$row]['price'] = ($cells->get('K'.$row)) ? $cells->get('K'.$row)->getValue():'';
            }

            // dd(count($array));

            for($i = 1; $i <= count($array); $i++){
                $importFirst = new Furniture($array[$i]);
                $importFirst->save();
            }

            foreach ($drawings as $drawing){
                $coordinates = $drawing->getCoordinates();
                $drawing_path = $drawing->getPath();
                $extension = pathinfo($drawing_path, PATHINFO_EXTENSION);

                $img_url = "/storage/furniture-img/{$coordinates}.{$extension}";
                $img_path = public_path($img_url);


                $contents = file_get_contents($drawing_path);

                file_put_contents($img_path, $contents);

                // dd($coordinates);
                // dd($img_url_altered);

                for($i = 1 ; $i <= count($array); $i++){
                    $furniture = Furniture::where('uuid', $array[$i]['uuid'])->first();
                    if($furniture){
                        $furniture->update([
                            'image' => "/furniture-img/B{$i}.{$extension}"
                        ]);
                    }
                }
            }



            // Storage::delete(public_path('/FurnitureData/'.$fileName));
            unlink(public_path('/FurnitureData/'.$fileName));


            // Excel::import(new FurnituresImport, \public_path('/FurnitureData/'.$fileName));
            return \redirect()->back();
            // return  $excelFile;
            // dd($request->all());
        }

    }
    public function deleteBulk(request $request){

        // dd($request->uuids);
        Furniture::whereIn('uuid', $request->uuids)->delete();
        return redirect()->back()->with('message', 'delete:200');
    }
}
