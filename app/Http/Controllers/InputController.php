<?php

namespace App\Http\Controllers;

use Ulid\Ulid;
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
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Class InputController
 *
 * @method string getPath()
 */
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



        // dd(is_string($request->image));

        if(is_string($request->image)){
            $check = $this->validateInput($request,'input');
            // dd($check['image']);
            if($check){
                $fileUrl = $check['image'];
                Furniture::create ([
                    'uuid' => Ulid::generate(),
                    'image' => $fileUrl,
                    'code' => $request->code,
                    'description' => $request->description,
                    'category' => $request->category,
                    'wood_type' => $request->woodtype,
                    'color' => $request->color,
                    'width' => $request->width,
                    'length' => $request->length,
                    'height' => $request->height,
                    'stock' => $request->stock,
                    'price' => $request->price,
                ]);
            }
        }else{
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
                    'uuid' => Ulid::generate(),
                    'image' => $fileUrl,
                    'code' => $request->code,
                    'description' => $request->description,
                    'category' => $request->category,
                    'wood_type' => $request->woodtype,
                    'color' => $request->color,
                    'width' => $request->width,
                    'length' => $request->length,
                    'height' => $request->height,
                    'stock' => $request->stock,
                    'price' => $request->price,
                ]);
            }
        }
        return redirect()->back()->with('message', 'input:200');
    }

    public function update(Request $request){

        // dd($request->all());
        $check = $this->validateInput($request,'update');
        if(is_string($request->sImage)){

            if($check){
                $furniture = Furniture::find($request->sUuid);
                // dd($furniture->first());
                $furniture->update([
                    'image' => $request->sImage,
                    'code' => $request->sCode,
                    'description' => $request->sDescription,
                    'category' => $request->sCategory,
                    'wood_type' => $request->sWoodtype,
                    'width' => $request->sWidth,
                    'color' => $request->sColor,
                    'length' => $request->sLength,
                    'height' => $request->sHeight,
                    'price' => $request->sPrice,
                    'stock' => $request->sStock,
                ]);
            }
        }else{
            if($check){
                if($check['sImage']){
                        $fileUrl = $request->file('sImage')->store('furniture-img');
                    }else {
                        $fileUrl = null;
                    }
                $furniture = Furniture::find($request->sUuid);
                // dd($furniture->first());
                $furniture->update([
                    'image' => $fileUrl,
                    'code' => $request->sCode,
                    'description' => $request->sDescription,
                    'category' => $request->sCategory,
                    'wood_type' => $request->sWoodtype,
                    'width' => $request->sWidth,
                    'color' => $request->sColor,
                    'length' => $request->sLength,
                    'height' => $request->sHeight,
                    'price' => $request->sPrice,
                    'stock' => $request->sStock,
                ]);
            }
        }


        // $this->validateInput($request,'update');
        return redirect()->back()->with('message', 'update:200');
        // return Redirect::route('input.index', ['message' => 'update:200']);
    }

    public function validateInput($input, $context){
        $validationInteger = "required|numeric|min:0|max_digits:6|not_in:0";
        $validationString = "required|string";
        $validationStock = "required|numeric|max_digits:6";

        // dd(is_string($input->sImage));


        if(is_string($input->image) || is_string($input->sImage)){
            $validationImage = $validationString;
        }else{
            $validationImage = "required|image|file|max:1024";
        }

        //To separate different error validation between input and update validation
        //pass the context to the function
        //if there is not context then it means that the validation is for update field and return different error variables
        if ($context == 'input'){
            return $input -> validate([
                    'image' => $validationImage,
                    'description' => $validationString,
                    'category' => $validationString,
                    'woodtype' => $validationString,
                    'color' => $validationString,
                    'width' => $validationInteger,
                    'height' => $validationInteger,
                    'length' => $validationInteger,
                    'stock' => $validationStock,
                    'price' => $validationInteger,
                ]);
        }
        elseif('update'){
            return $input -> validate([
                    'sImage' => $validationImage,
                    'sDescription' => $validationString,
                    'sCategory' => $validationString,
                    'sWoodtype' => $validationString,
                    'sColor' => $validationString,
                    'sWidth' => $validationInteger,
                    'sHeight' => $validationInteger,
                    'sLength' => $validationInteger,
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

    public function import(Request $request){
        if ($request->hasFile('file')) {
            //* Save excel to local storage
            $fileName = $this->saveExcelFile($request->file('file'));
            //* Process the uploaded excel file and return as array (exluding image files)
            $array = $this->processExcelData($fileName);
            //* Save uploaded excel data to database
            $this->saveFurnitureData($array);
            //* Get the drawing from excel and update image field in furniture based on saved image on laravel
            $this->processDrawings($array, $fileName);
            //* Delete uploaded file to avoid unecessary excess storage
            $this->deleteUploadedFile($fileName);
            return redirect()->back()->with('message', 'import:200');
        }
    }

    private function saveExcelFile(UploadedFile $file): string{
        $fileName = $file->getClientOriginalName();
        $file->move('FurnitureData', $fileName);
        return $fileName;
    }

    private function loadExcelData(string $fileName) {
        $reader = new Xlsx();
        $spreadsheet = $reader->load(public_path('FurnitureData/' . $fileName));
        return $spreadsheet->getActiveSheet();
    }

    private function processExcelData(string $fileName): array{
        $cells = $this->loadExcelData($fileName)->getCellCollection();
        $array = [];
        for ($row = 2; $row <= $cells->getHighestRow(); $row++) {
            $array[$row]['uuid'] = Ulid::generate();
            $array[$row]['image'] = $cells->get('B' . $row) ? $cells->get('B' . $row)->getValue() : '';
            $array[$row]['code'] = $cells->get('C' . $row) ? $cells->get('C' . $row)->getValue() : '';
            $array[$row]['description'] = $cells->get('D' . $row) ? $cells->get('D' . $row)->getValue() : '';
            $array[$row]['category'] = $cells->get('E' . $row) ? $cells->get('E' . $row)->getValue() : '';
            $array[$row]['wood_type'] = $cells->get('F' . $row) ? $cells->get('F' . $row)->getValue() : '';
            $array[$row]['width'] = $cells->get('G' . $row) ? $cells->get('G' . $row)->getValue() : '';
            $array[$row]['length'] = $cells->get('H' . $row) ? $cells->get('H' . $row)->getValue() : '';
            $array[$row]['height'] = $cells->get('I' . $row) ? $cells->get('I' . $row)->getValue() : '';
            $array[$row]['stock'] = $cells->get('J' . $row) ? $cells->get('J' . $row)->getValue() : '';
            $array[$row]['color'] = $cells->get('K' . $row) ? $cells->get('K' . $row)->getValue() : '';
            $array[$row]['price'] = $cells->get('L' . $row) ? $cells->get('L' . $row)->getValue() : '';
        }
        return $array;
    }

    private function saveFurnitureData(array $array): void{
        foreach ($array as $data) {
            Furniture::create($data);
        }
    }


    private function processDrawings(array $array, string $fileName): void{
        $drawings = $this->loadExcelData($fileName)->getDrawingCollection();
        foreach ($drawings as $index => $drawing) {
            $coordinates = $drawing->getCoordinates();
            $drawing_path = $drawing->getPath();
            $img_url = "/storage/furniture-img/{$coordinates}.jpg";
            $img_path = public_path($img_url);
            $contents = file_get_contents($drawing_path);
            file_put_contents($img_path, $contents);

            foreach($array as $index => $data){
                $furniture = Furniture::where('uuid',$data['uuid'])->first();
                if($furniture){
                    $furniture->update([
                        'image' => "furniture-img/B{$index}.jpg"
                    ]);
                }
            }
        }
    }

    private function deleteUploadedFile(string $fileName): void{
        unlink(public_path('FurnitureData/' . $fileName));
    }

    public function deleteBulk(request $request){

        // dd($request->uuids);
        Furniture::whereIn('uuid', $request->uuids)->delete();
        return redirect()->back()->with('message', 'delete:200');
    }
}
