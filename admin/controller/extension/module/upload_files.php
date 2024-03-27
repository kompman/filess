<?php
class ControllerExtensionModuleUploadFiles extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/upload_files');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/module/upload_files');

        $this->getList();
    }

    protected function getList() {
        $data['add'] = $this->url->link('extension/module/upload_files/add', 'user_token=' . $this->session->data['user_token'], true);
        $data['files'] = array();

        $results = $this->model_extension_module_upload_files->getFiles();

       foreach ($results as $result) {
    $file_url = $this->model_extension_module_upload_files->getFileUrl($result['file_path']);

    $data['files'][] = array(
        'file_id'    => $result['file_id'],
        'name'       => $result['name'],
        'file_path'  => $result['file_path'],
        'file_url'   => $file_url, // Добавляем URL файла
        'insert_code' => '{{ upload_file_' . $result['file_id'] . ' }}' // Также можно сформировать код для вставки
    );
}

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/upload_files_list', $data));
    }

    public function add() {
        $this->load->language('extension/module/upload_files');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/module/upload_files');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $file_name = html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8');
           $file_path = 'fileup/' . basename($file_name);

            if (move_uploaded_file($this->request->files['file']['tmp_name'], DIR_APPLICATION . '../' . $file_path)) {
    $this->model_extension_module_upload_files->addFile(array(
        'name' => $this->request->post['name'],
        'file_path' => $file_path 
    ));

                $this->session->data['success'] = $this->language->get('text_success');
                $this->response->redirect($this->url->link('extension/module/upload_files', 'user_token=' . $this->session->data['user_token'], true));
            } else {
                $this->error['warning'] = $this->language->get('error_upload');
            }
        }

        $this->getForm();
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/upload_files')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 255)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }

protected function getForm() {
    $data['action'] = $this->url->link('extension/module/upload_files/add', 'user_token=' . $this->session->data['user_token'], true);

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('extension/module/upload_files_form', $data));
}

}
