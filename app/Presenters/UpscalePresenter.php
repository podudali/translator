<?php
// Not working yet...
namespace App\Presenters;

use Nette;
use Nette\Application\UI\Presenter;
use Solid\Deepai\Deepai;

class UpscalePresenter extends Presenter{

public function __construct(){

}

public function upload(): void{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploaded_file'])) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/translator/uploads/INPUT";
        // echo $target_dir;
        $target_file = $target_dir . basename($_FILES['uploaded_file']['name'][0]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Проверка на ограничения на размер и тип файла
        if ($_FILES['uploaded_file']['size'][0] > 8000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "mp3" && $imageFileType != "mp4"
        && $imageFileType != "avi" && $imageFileType != "mkv"&& $imageFileType != "mov" 
        && $imageFileType != "flv" && $imageFileType != "vob") {
            echo "Sorry, only JPG, JPEG, PNG, GIF, MP3, MP4, AVI, MKV, MOV, FLV, VOB files are allowed.";
            $uploadOk = 0;
        }
        // Если все проверки прошли успешно, попробуем загрузить файл на сервер
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'][0], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES['uploaded_file']['name'][0])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

public function renderDefault(){
    $this->upload();
// $input_file = "input.mp4";
// $output_file = "output.mp4";
// $scale_size = "720";
// $upscale_type = "upscale";
// $algorithm = "waifu2x";
// $denoise_level = "3";
// $command = "python -m video2x -i $input_file -o $output_file -p3 $upscale_type -h $scale_size -a $algorithm -n$denoise_level";
// exec($command);

$deepai = new Deepai('api key');

// $deepai->setImage('image url');
$deepai->$_SERVER['DOCUMENT_ROOT'] . "/translator/uploads/INPUT";   
// you can use a url or a local file path , for example : 

$deepai->setImage(new CURLFile('image.jpg'));

$deepai->colorize();

$result = $deepai->apply();

$url = $result->url();

$result->save('output.jpg');

/*
 * you can get the all response data from this method 
 */
$allResponseData = $result->getData();

}
}
