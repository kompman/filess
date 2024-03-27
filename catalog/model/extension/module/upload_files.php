<?php
class ModelExtensionModuleUploadFiles extends Model {
    public function getFiles() {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "upload_files`");
        return $query->rows;
    }

    public function getFile($file_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "upload_files` WHERE file_id = " . (int)$file_id);
        return $query->row;
    }

    public function getFileUrl($file_path) {
        // Прямое использование 'fileup/' предполагает, что файлы располагаются в папке fileup в корне сайта.
        return HTTPS_SERVER . 'fileup/' . $file_path;
    }
}
