<?php

namespace App\Http\Controllers;
use Office365\SharePoint\ClientContext;
use Office365\Runtime\Auth\UserCredentials;
use App\Jobs\uploadFiles;
use App\Models\LoadedFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Office365\SharePoint\File as FileSP;

require_once '../vendor/autoload.php';


class SubirImagenController extends Controller
{
    public function vistaSubirImagen(){
        return view('subir-imagen');
    }


    public function cargarImagen(Request $request){
        $request->validate([
            'file' => ['required', File::types(['jpeg', 'jpg', 'png', 'mp4', 'avi', 'mkv', 'flv', 'mov', 'wmv', 'divx', 'xvid', 'rm'])],
            'directory' => 'required',
        ]);
        $guardado = str_replace(" ", "-", $_FILES['file']['name']);
        $file = $request->file('file')->storeAs('artes', $guardado);
        $directory = $request->directory;
        uploadFiles::dispatch($file, $directory);
        $filemsg = str_replace("artes/", "", $guardado);
        session()->flash('msj', 'The file '.$filemsg.' is being loaded to SharePoint');
        return view('subir-imagen');
    }

    public function fileList(){
        $files = LoadedFiles::all();
        return view('file-list', compact('files'));
    }

    public function tryGetFile($file){
        try {
            $file->get()->executeQuery();
        }
        catch (RequestException $ex){
            if($ex->getCode() === 404){
                return false;
            }
            throw $ex;
        }
        return true;
    }
    

    public function downloadFile($id_file){//Función NO hace lo requerido
        $settings = include('C:/xampp/htdocs/laravelSharepoint/phpSPO/tests/Settings.php'); //Incluir rutas absolutas... No funcionó con rutas relativas
        $creds = new UserCredentials($settings['UserName'], $settings['Password']);
        $ctx = (new ClientContext($settings['TeamSiteUrl']))->withCredentials($creds);
        $files = LoadedFiles::findOrFail($id_file);
        $rootFolder = $ctx
            ->getWeb()
            ->getFolderByServerRelativeUrl($files->directory)
            ->get()
            ->executeQuery();
//        var_dump($rootFolder);
        echo "<pre>";
        print_r($rootFolder);
        echo "</pre>";
        foreach ($rootFolder->getFiles() as $file) {
            echo "Dentro del foreach";
//            $localPath = "C:/usuarios/letus/Descargas/Prueba/";
            $localPath = join(DIRECTORY_SEPARATOR, [sys_get_temp_dir(), $file->getName()]);
            $fh = fopen($localPath, 'w+');
            $file->download($fh)->executeQuery();
            fclose($fh);
            print "File: ".$file->getServerRedirectedUrl()." has been downloaded into ".$localPath;
//            return redirect()->route('file-list');
        }
    }
}
