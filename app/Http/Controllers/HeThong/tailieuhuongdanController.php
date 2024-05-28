<?php

namespace App\Http\Controllers\HeThong;

use App\Http\Controllers\Controller;
use App\Models\HeThong\tailieuhuongdan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class tailieuhuongdanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('admin')) {
                return redirect('/');
            };
            return $next($request);
        });
    }

    public function index()
    {
        $model = tailieuhuongdan::all();
        $inputs['url'] = '/TaiLieuHuongDan/';
        return view('TaiLieuHuongDan.ThongTin')
            ->with('model', $model)
            ->with('inputs', $inputs)
            ->with('pageTitle', 'Thông tin hỗ trợ');
    }

    public function store(Request $request)
    {
        $inputs=$request->all();
        $inputs['matailieu'] = (string) getdate()[0];
        if (isset($inputs['noidung'])) {
            $filedk =$request->file('noidung');
            $inputs['noidung'] = $inputs['matailieu'].$filedk->getClientOriginalName();
            $filedk->move(public_path() . '/data/tailieuhuongdan/', $inputs['noidung']);
        }

        tailieuhuongdan::create($inputs);

        return redirect('/TaiLieuHuongDan/ThongTin');
    }

    public function delete(Request $request)
    {
        $id=$request->id;
        $model = tailieuhuongdan::findOrFail($id);
        if (isset($model)) {
            if (file_exists('/data/tailieuhuongdan/' . $model->noidung)) {
                File::Delete('/data/tailieuhuongdan/' . $model->noidung);
            }
            $model->delete();
        }

        return redirect('/TaiLieuHuongDan/ThongTin');
    }

    public function upload(Request $request, string $id)
    {
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return $this->saveFile($save->getFile(), $id);
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    // protected function saveFile(UploadedFile $file, string $id)
    // {
    //     $fileName = $this->createFilename($file);

    //     $model = tailieuhuongdan::where('id', $id)->first();

    //     // Build the file path
    //     if (isset($model->link1)) {
    //         if (File::exists($model->link1)) {
    //             File::delete($model->link1);
    //         }
    //         $split_link = explode("tailieuhuongdan/", $model->link1);
    //         $filePath = $split_link[0] . 'tailieuhuongdan/';
    //     } else {
    //         $filePath = "data/" . Str::slug(Str::limit($model->tentailieu, 145) . getdate()[0]) . "/tailieuhuongdan/";
    //     }
    //     $finalPath = public_path($filePath);

    //     // move the file name
    //     $file->move($finalPath, $fileName);

    //     $model->update([
    //         'link1' => $filePath . $fileName,
    //     ]);

    //     return response()->json([
    //         'path' => asset($filePath),
    //         'name' => $fileName
    //     ]);
    // }
    protected function saveFile(UploadedFile $file, string $id)
    {
        // Create a new filename for the uploaded file
        $fileName = $this->createFilename($file);
    
        // Retrieve the model by id
        $model = tailieuhuongdan::find($id);
        if (!$model) {
            return response()->json(['error' => 'Model not found'], 404);
        }
    
        // Determine the file path
        if ($model->link1) {
            // Extract the base path from the existing link
            $basePath = dirname($model->link1) . '/';
            
            // Delete the existing file if it exists
            if (File::exists($model->link1)) {
                File::delete($model->link1);
            }
        } else {
            // Create a new base path
            // $basePath = 'data/' . Str::slug(Str::limit($model->tentailieu, 145) . time()) . '/tailieuhuongdan/';
            $basePath = 'data/tailieuhuongdan/video';
        }
    
        // Define the final path to store the file
        $finalPath = public_path($basePath);
    
        // Move the file to the final destination
        $file->move($finalPath, $fileName);
    
        // Update the model's link1 with the new file path
        $model->update(['link1' => $basePath . $fileName]);
    
        // Return a JSON response with the file path and name
        return response()->json([
            'path' => asset($basePath),
            'name' => $fileName
        ]);
    }
    
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace("." . $extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }

    public function update(Request $request, string $id)
    {
        // if (!chkPhanQuyen('baihoc', 'thaydoi')) {
        //     return view('errors.noperm')->with('machucnang', 'baihoc');
        // }

        // $model = tailieuhuongdan::where('id', $id)->first();
        $model = tailieuhuongdan::findOrFail($id);
// dd($model);
        if (isset($model)) {
            if ($request->hasFile('anh-nen-video')) {
                if (File::exists($model->link2)) {
                    File::delete($model->link2);
                }
                $filedk =$request->file('anh-nen-video');
                // $filePath = 'data/tailieuhuongdan/anhvideo/';

                // $finalPath = public_path($filePath);

                // $extension = $request->file('anh-nen-video')->getClientOriginalExtension();
                // $fileName = Str::limit(str_replace("." . $extension, "", $request->file('anh-nen-video')->getClientOriginalName()), 210);

                // $fileName .= "_" . md5(time()) . "." . $extension;

                // $request->file('anh-nen-video')->move($finalPath, $fileName);
                

                // $model->update([
                //     'link2' => $filePath . $fileName
                // ]);
                $filedk =$request->file('anh-nen-video');
                $inputs['link2'] = $model->matailieu.$filedk->getClientOriginalName();
                $filedk->move(public_path() . '/data/tailieuhuongdan/anhvideo/', $inputs['link2']);
                $model->update(['link2'=>$inputs['link2']]);
            }

            if($request->hasFile('noidung')){
                if (File::exists($model->noidung)) {
                    File::delete($model->noidung);
                }
                $filedk =$request->file('noidung');
                $inputs['noidung'] = $model->matailieu.$filedk->getClientOriginalName();
                $filedk->move(public_path() . '/data/tailieuhuongdan/', $inputs['noidung']);
                $model->update(['noidung'=>$inputs['noidung']]);
            }

            $model->update([
                'tentailieu' => $request['tentailieu'],
                // 'stt' => $request['stt']
            ]);
        }

        return redirect('/TaiLieuHuongDan/ThongTin')
            ->with('success', 'Cập nhật thành công');
    }

    public function XoaVideo($id)
    {
        $model=tailieuhuongdan::findOrFail($id);
        if(isset($model)){
            if (File::exists($model->link1)) {
                File::delete($model->link1);
            }
            $model->update(['link1'=>null]);
        }

        return response()->json([
            'status'=>true
        ]);
    }
}
