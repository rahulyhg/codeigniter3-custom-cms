<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Article Class.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Controller
 * @desc Article Controller
 */
class Article extends CI_Controller
{
    private $class_path_name;

    /**
     * load the parent constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Article_model');
        $this->class_path_name = $this->router->fetch_class();
    }

    /**
     * Index Page for this controller.
     */
    public function index($category = '')
    {
        $param = [];
        $json = [];
        $this->data['categories'] = $this->Article_model->GetCategories();
        $category_info = '';
        if ($category != '') {
            $category_info = $this->Article_model->GetCatagoryByURI($category);
            if (!$category_info) {
                show_404();
                exit();
            }
            $param['conditions']['id_article_category'] = $category_info['id_article_category'];
        }
        if ($this->input->get_post('perpage')) {
            $param['limit']['from'] = (int) $this->input->get_post('perpage');
            $param['base_url'] = current_url();
        }
        if ($this->input->is_ajax_request()) {
            $json['html'] = $this->list_data($param);
            header('Content-type: application/json');
            exit(
                json_encode($json)
            );
        }
        $this->data['list_data'] = $this->list_data($param);
    }

    /**
     * detail page.
     *
     * @param string $uri_path
     */
    public function detail($uri_path = '')
    {
        $record = $this->Article_model->GetArticleByURI($uri_path);
        if (!$record) {
            show_404();
            exit();
        }
        $this->data['categories'] = $this->Article_model->GetCategories();
        $this->data['page_title'] = $record['title'];
        $this->data['article'] = $record;
    }

    /**
     * list article with template.
     */
    private function list_data($param = [])
    {
        $total_records = $this->Article_model->CountArticles($param);
        $records = $this->Article_model->GetArticles($param);
        if (isset($param['base_url'])) {
            $paging['base_url'] = $param['base_url'];
        } else {
            $paging['base_url'] = current_url();
        }
        $paging['per_page'] = SHOW_RECORDS_DEFAULT;
        $paging['total_rows'] = $total_records;
        $paging['is_ajax'] = true;
        $data['records'] = $records;
        $data['pagination'] = custom_pagination($paging);

        return $this->load->view(TEMPLATE_DIR.'/'.$this->class_path_name.'/list_data', $data, true);
    }
}

/* End of file Article.php */
/* Location: ./application/controllers/Article.php */
