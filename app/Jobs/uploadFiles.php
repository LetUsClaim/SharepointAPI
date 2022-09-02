<?php

namespace App\Jobs;

use App\Models\LoadedFiles;
use Office365\Runtime\Auth\UserCredentials;
use Office365\SharePoint\ClientContext;

use Illuminate\Http\Request;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class uploadFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
//    protected $file;
    protected $file;
    protected $directory;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file, $directory)
    {
        $this->directory = $directory;
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $settings = include('C:/xampp/htdocs/laravelSharepoint/phpSPO/tests/Settings.php'); //Incluir rutas absolutas... No funcionó con rutas relativas
        try {
            $credentials = new UserCredentials($settings['UserName'], $settings['Password']);
            $ctx = (new ClientContext($settings['Url']))->withCredentials($credentials);
            $localPath = "C:/xampp/htdocs/laravelSharepoint/storage/app/public";
            $targetLibraryTitle = $this->directory;
            $targetList = $ctx->getWeb()->getLists()->getByTitle($targetLibraryTitle);
            $searchPrefix = $localPath . '/' . $this->file;
            foreach(glob($searchPrefix) as $filename) {
                $uploadFile = $targetList->getRootFolder()->uploadFile(basename($filename),file_get_contents($filename));
                $ctx->executeQuery();
            }
            $file = explode('/', $this->file);
            LoadedFiles::create([
                'directory' => $this->directory,
                'file' => $file[1],
            ]);
        }
        catch (Exception $e) {
                session()->flash('msj', 'Error: '.$e->getMessage());
                return view('subir-imagen');
        }

    }
}
