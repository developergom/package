<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Portalga
 *
 * @author nanank
 */
class Portalga extends CI_Controller {

    protected $header;
    protected $categories;
    protected $tags;

    public function __construct() {
        parent::__construct();
        $this->load->helper(['text', 'date']);
        $this->load->model('gaportal/post_model', 'post');
        $this->load->model('gaportal/post_to_category_model', 'post_to_category');
        $this->load->model('gaportal/post_to_tag_model', 'post_to_tag');
        $this->load->model('gaportal/category_model', 'category');
        $this->load->model('gaportal/tag_model', 'tag');
        $this->header['menu'] = $this->__set_menu();
        $this->header['meta'] = 'GOM General Affairs';
        $this->categories = $this->category->as_array()->get_all();
        $this->tags = $this->tag->as_array()->get_all();
    }

    public function index() {
        $data = [
            'slider' => $this->post->limit(5)->order_by('post_publish_when', 'desc')->as_array()->get_many_by('post_status', 'publish'),
            'general_services' => $this->__category('general_service'),
            'procurement' => $this->__procurement(),
            'engineering' => $this->__engineering(),
            'security' => $this->__security(),
                //'categories' => $this->categories,
                //'tags' => $this->tags
        ];
        $this->load->view('gaportal/header', $this->header);
        $this->load->view('gaportal/landing', $data);
        $this->load->view('gaportal/footer');
    }

    private function __category($slug) {
        $category = [];
        foreach ($this->categories as $cat) {
            if ($cat['category_slug'] === $slug) {
                foreach ($this->categories as $cat2) {
                    if ($cat2['category_parent'] == $cat['category_id']) {
                        $category[] = $cat2;
                    }
                }
            }
        }
        return $category;
    }

    private function __procurement() {
        $procurement = [];
        $category = $this->category->dropdown('category_name');
        foreach ($this->__category('procurement') as $procat) {
            $category_id[] = $procat['category_id'];
            $category_id[] = $procat['category_parent'];
        }
        foreach ($this->post_to_category->with('post')->limit(9)->as_array()->get_many_by('category_id', $category_id) as $ptc) {
            $procurement['post_to_category'][] = object_to_array($ptc['post']) + ['index' => url_title($category[$ptc['category_id']])];
            $procurement['category'][] = $category[$ptc['category_id']];
        }
        return $procurement;
    }

    private function __engineering() {
        $engineering['category'] = $this->category->as_array()->get_by('category_slug', 'engineering');
        $post_to_category = $this->post_to_category->with('post')->limit(5)->as_array()->get_many_by('category_id', $engineering['category']['category_id']);
        foreach ($post_to_category as $ptc)
            $engineering['post_to_category'][] = object_to_array($ptc['post']);
        return $engineering;
    }

    private function __security() {
        $security = [];
        foreach ($this->__category('security') as $procat) {
            $category_id[] = $procat['category_id'];
            $category_id[] = $procat['category_parent'];
        }
        foreach ($this->post_to_category->with('post')->limit(4)->as_array()->get_many_by('category_id', array_unique($category_id)) as $ptc)
            $security[] = object_to_array($ptc['post']);
        return distinct_array($security);
    }

    private function __set_menu() {
        $menu = [
            '<a href="#general_service">General Service</a>',
            '<a href="#procurement">Procurement</a>',
            '<a href="#engineering">Engineering</a>',
            '<a href="#security">Security</a>'
        ];
        return $menu;
    }

    public function articles($index = NULL, $page = 0) {
        $this->load->library('pagination');
        $perpage = 5;
        $page = !empty($page) ? $perpage * ($page - 1) : 0;
        $config['base_url'] = base_url('portalga/articles/page/');
        $config['per_page'] = $perpage;
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->post->count_by('post_status', 'publish');
        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();
        $articles = $this->post->with('ptc')->order_by('post_publish_when', 'DESC')->limit($perpage, $page)->get_many_by('post_status', 'publish');
        $this->load->view('gaportal/header', $this->header);
        $this->load->view('gaportal/articles', ['articles' => $articles, 'pagination' => $pagination, 'categories' => $this->categories, 'tags' => $this->tags]);
        $this->load->view('gaportal/footer');
    }

    public function article($slug = NULL) {
        if (empty($slug))
            $this->notfound();
        $article = $this->post->with('ptc')->with('ptt')->get_by('post_slug', $slug);
        if (!empty($article->ptt)) {
            foreach (array_intersect_key($this->tags, $article->ptt) as $tag)
                $meta[] = $tag['tag_content'];
        } else {
            $meta = ['GOM', 'Portal GA'];
        }
        $this->header['meta'] = implode(', ', $meta);
        $this->load->view('gaportal/header', $this->header);
        $this->load->view('gaportal/article', ['article' => $article, 'categories' => $this->categories, 'tags' => $this->tags]);
        $this->load->view('gaportal/footer');
    }

    public function category($category) {
        debug($category);
    }

    public function tag($tag) {
        debug($tag);
    }

    public function notfound() {
        exit('notfound');
    }

}
