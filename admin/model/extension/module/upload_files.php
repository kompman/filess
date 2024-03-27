<?php
class ModelExtensionModuleUploadFiles extends Model {
public function addFile($data) {
    // Убедитесь, что 'fileup/' добавляется только один раз
    $this->db->query("INSERT INTO `" . DB_PREFIX . "upload_files` SET name = '" . $this->db->escape($data['name']) . "', file_path = '" . $this->db->escape($data['file_path']) . "'");
}



    public function getFiles() {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "upload_files`");
        return $query->rows;
    }
public function getFileUrl($file_path) {
   
    return HTTPS_CATALOG . $file_path;
}

    public function deleteFile($file_id) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "upload_files` WHERE file_id = '" . (int)$file_id . "'");
    }
}
