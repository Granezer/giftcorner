<?php

class ImageUploader {

    protected $uploaded_file = array();
    protected $destination = "";
    protected $maximum_size = "51200";
    protected $message = array();
    protected $permitted_files = array(
        "image/gif", 
        "image/jpeg", 
        "image/png", 
        "application/pdf",
        'application/msword',
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "application/zip",
        "application/octet-stream",
        "application/x-zip-compressed",
        "multipart/x-zip",
        "application/x-rar-compressed",
        // 'doc'  => 'application/msword',
        // 'docx'  => 'application/msword',
        // 'xls'  => 'application/vnd.ms-excel',
        // 'xlsx'  => 'application/vnd.ms-excel',
        // 'ppt'  => 'application/vnd.ms-powerpoint'
    );
    protected $image_title = "";
    protected $file_type = "";
    protected $file_name = "";
    protected $file_extension = "";

    public function __construct($path, $uploaded_image, $image_title) {
        if (!is_dir($path)) {
            throw new Exception("File path is not a directory. Check and rectify");
        }
        if (!is_writable($path)) {
            throw new Exception("File path can't be written to. Check and rectify");
        }
        $this->destination = $path;
        $this->uploaded_file = $uploaded_image;
        $this->image_title = $image_title;
    }

    public function moveUploadedImage() {
        $field = $this->uploaded_file;
        $no_error = $this->checkError($field['error']);

        if ($no_error) {
            $size_ok = $this->checkSize($field['size']);
            $type_ok = $this->checkType($field['type']);

            if ($size_ok && $type_ok) {
                $file_name = $this->checkName($this->image_title);
                if ($file_name == null) {
                    throw new Exception("The name of the file is null");
                }
                move_uploaded_file($field['tmp_name'], $this->destination . "/" . $file_name);
                return $file_name;
            }
        }
    }

    protected function checkName($name) {
        $file_name = md5($name);

        if ($this->file_type == "image/gif") {
            $this->file_name = $file_name;
            $this->file_extension = ".gif";
            $file_name = $file_name . ".gif";
        } else if (in_array($this->file_type, array("image/jpg", "image/jpeg"))) {
            $this->file_name = $file_name;
            $this->file_extension = ".jpg";
            $file_name = $file_name . ".jpg";
        } else if ($this->file_type == "image/png") {
            $this->file_name = $file_name;
            $this->file_extension = ".png";
            $file_name = $file_name . ".png";
        } else if ($this->file_type == "application/pdf") {
            $this->file_name = $file_name;
            $this->file_extension = ".pdf";
            $file_name = $file_name . ".pdf";
        } else if ($this->file_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
            $this->file_name = $file_name;
            $this->file_extension = ".docx";
            $file_name = $file_name . ".docx";
        } else if (in_array($this->file_type, array("application/zip", "application/octet-stream","application/x-zip-compressed","multipart/x-zip","application/x-rar-compressed"))) {
            $this->file_name = $file_name;
            $this->file_extension = ".zip";
            $file_name = $file_name . ".zip";
        }

        return $file_name;
    }

    protected function checkError($error) {
        switch ($error) {
            case 0 :
                return true;
            case 1 :
            case 2 :
                $this->message[] = "file exceeds maximum size." . $this->getMaxSize();
                return true;
            case 3 :
                $this->message[] = "Error uploading file. Please try again.";
                return false;
            case 4 :
                $this->message[] = 'No file selected.';
                return false;
            default :
                $this->message[] = "System error uploading. Contact Admin.";
                return false;
        }
    }

    protected function checkType($type) {
        if (!in_array($type, $this->permitted_files)) {
            throw new Exception("The file uploaded is not of the permitted type ($type)");
            return false;
        } else {
            $this->file_type = $type;
            return true;
        }
    }

    protected function checkSize($size) {
        if ($size == 0) {
            throw new Exception("The image uploaded has a size of 0kb");
            return false;
        } else {
            return true;
        }
    }
}