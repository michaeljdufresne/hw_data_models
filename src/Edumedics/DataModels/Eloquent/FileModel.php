<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileModel extends Model {

    const DIRECTORY_BATCH_SIZE = 1000;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'file';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @param UploadedFile $file
     * @return mixed
     */
    public static function CreateFromInputFile(UploadedFile $file){
        $path = $file->getRealPath();
        $sha = sha1_file($path);

        $mime = $file->getMimeType();
        $extension = $file->getExtension();
        $fileName = $file->getClientOriginalName();

        $fileModel = self::create([
            'sha' => $sha,
            'name' => $fileName,
            'extension' => $extension,
            'mime_type' => $mime,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);
        if(!empty($fileModel)) {
            $file->move(FileModel::GetDirectoryByFileId($fileModel->id) . "/", $fileModel->id);
        }

        return $fileModel;
    }

    /**
     * @param FileModel $matchFile
     * @return mixed
     */
    public static function CreateCopy(FileModel $matchFile){
        $fileModelCopy = self::create([
            'sha' => $matchFile->sha,
            'name' => $matchFile->name,
            'extension' => $matchFile->extension,
            'mime_type' => $matchFile->mime,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);

        copy($matchFile->getFullPath(), FileModel::GetPathByFileId($matchFile->id));
        return $fileModelCopy;
    }

    /**
     * @param $id
     * @return string
     */
    public static function GetPathByFileId($id){
        return  FileModel::GetDirectoryByFileId($id). "/". $id;
    }

    /**
     * @param $id
     * @return string
     */
    public static function GetDirectoryByFileId($id){
        $folder = floor($id / FileModel::DIRECTORY_BATCH_SIZE);
        return storage_path("files/") . $folder;
    }

    /**
     * @param $name
     * @param $ext
     * @param $mime
     * @return mixed
     */
    public static function CreateEmptyFile($name, $ext, $mime){
        $fileModel = FileModel::create([
            'sha' => '',
            'name' => $name,
            'extension' => $ext,
            'mime_type' => $mime,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);

        mkdir(dirname($fileModel->getFullPath()), 0755, true);
        file_put_contents($fileModel->getFullPath(), '');
        return $fileModel;
    }

    /**
     * @return string
     */
    public function getFullPath(){
        return FileModel::GetDirectoryByFileId($this->id) . "/" . $this->id;
    }
}