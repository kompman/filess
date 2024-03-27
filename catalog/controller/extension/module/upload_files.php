<?php 
public function index() {
    $this->load->model('extension/module/upload_files');
    
    $data['files'] = array();

    $files = $this->model_extension_module_upload_files->getFiles();

    foreach ($files as $file) {
        $data['files'][] = array(
            'file_id' => $file['file_id'],
            'name' => $file['name'],
            'url' => $this->model_extension_module_upload_files->getFileUrl($file['file_path'])
        );
    }

    $this->response->setOutput($this->load->view('your_view_file', $data));
}
