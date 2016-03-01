<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Portalga extends CI_Controller {

    protected $header;
    protected $perpage = 4;
    protected $categories;
    protected $tags;

    public function __construct() {
        parent::__construct();

        //$this->perpage = ROW_PERPAGE;
        $this->load->helper(['text', 'date']);
        $this->load->model('gaportal/post_model', 'post');
        $this->load->model('gaportal/post_to_category_model', 'post_to_category');
        $this->load->model('gaportal/post_to_tag_model', 'post_to_tag');
        $this->load->model('gaportal/category_model', 'category');
        $this->load->model('gaportal/tag_model', 'tag');
        $this->header['menu'] = $this->__set_menu();
        $this->header['meta'] = 'GOM General Affairs';
        $this->categories = $this->category->get_all();
        $this->tags = $this->tag->get_all();
    }

    public function index() {
        $this->load->view('gaportal/header', $this->header);
        $this->load->view('gaportal/landing', $this->__data());
        $this->load->view('gaportal/footer');
    }

    private function __data() {
        foreach ($this->__top_category() as $category) {
            if ($category->slug == 'general_service')
                $general_service = $this->__get_sub_category($category->id);

            if ($category->slug == 'procurement') {
                $procurement['sub'] = $this->__get_sub_category($category->id);
                $procurement['sub'][] = $this->category->get($category->id);
                $post[$category->id] = $category->slug;
                foreach ($this->__get_sub_category($category->id) as $subcat)
                    $post[$subcat->category_id] = $subcat->category_slug;

                foreach ($post as $key => $value)
                    $procurement['post'][$value] = $this->__get_post_by_category($key);
            }

            if ($category->slug == 'engineering') {
                $engineering['category'] = $this->category->get($category->id);
                $engineering['post'] = $this->__get_post_by_category($category->id);
            }

            if ($category->slug == 'security')
                $security = $this->__get_post_by_category($category->id);
        }

        return [
            'slider' => $this->__get_post_by_category(),
            'general_service' => $general_service,
            'procurement' => $procurement,
            'engineering' => $engineering,
            'security' => $security
        ];
    }

    private function __get_post_by_category($category_id = 0) {
        $post_to_category = [];
        if (empty($category_id)) {
            $get = $this->post_to_category->with('post')->get_all();
        } else {
            $get = $this->post_to_category->with('post')->get_many($category_id);
        }

        foreach ($get as $index => $ptc) {
            if ($ptc->post->post_status == 'publish')
                $post_to_category[] = $ptc->post;

            if ($index == $this->perpage)
                break;
        }

        return distinct_array($post_to_category);
    }

    private function __get_sub_category($category_id = 0) {
        $sub_categories = [];
        foreach ($this->categories as $category) {
            if ($category->category_parent == $category_id)
                $sub_categories[] = $category;
        }

        return $sub_categories;
    }

    private function __top_category() {
        $categories = [];
        foreach ($this->categories as $category) {
            if ($category->category_parent == FALSE && $category->category_name != 'Information' && $category->category_name != 'Uncategorized')
                $categories[] = [
                    'id' => $category->category_id,
                    'parent' => $category->category_parent,
                    'name' => $category->category_name,
                    'slug' => $category->category_slug
                ];
        }

        return array_to_object($categories);
    }

    public function article($type = NULL, $slug = NULL) {
        $this->load->library('pagination');
        $this->load->view('gaportal/header', $this->header);
        $data['categories'] = $this->categories;
        $data['tags'] = $this->tags;

        switch ($type) {
            case 'category' :
            case 'tag' :
                $this->load->view('articles', $data + $this->__type($slug));
                break;
            case 'read' :
                $this->load->view('article', $data + $this->__read($slug));
                break;
            default :
                $this->load->view('articles', $data + $this->__type());
        }

        $this->load->view('gaportal/footer');
    }

    private function __type() {
        $slug = func_get_args();
        $type = $this->uri->segment(3);

        if (!empty($type) && $type != 'page') {
            if (empty($slug))
                show_404();

            $slug_type = [];
            foreach ($this->{plural($type)} as $row) {
                if ($row->{$type . '_slug'} == $slug[0])
                    $slug_type = $row;
            }
        }

        if (empty($type) OR $type == 'page') {
            $article = $this->post->get_many_by('post_status', 'publish');
        } else {
            foreach ($this->{'post_to_' . $type}->with('post')->get_many($slug_type->{$type . '_id'}) as $value) {
                if ($value->post->post_status == 'publish')
                    $article[] = $value->post;
            }
        }

        $segment = (!empty($type) && $type != 'page') ? 6 : 4;
        $url = (!empty($type) && $type != 'page') ? $type . '/' . $slug_type->{$type . '_slug'} . '/page/' : 'page/';
        $page = !empty($this->uri->segment($segment)) ? $this->perpage * ($this->uri->segment($segment) - 1) : 0;
        usort($article, function($a, $b) {
            return strcmp($a->post_publish_when, $b->post_publish_when);
        });

        $config['base_url'] = base_url('portalga/article/' . $url);
        $config['total_rows'] = count($article);
        $config['per_page'] = $this->perpage;
        $config['uri_segment'] = $segment;
        $this->pagination->initialize($config);

        return [
            'articles' => array_slice($article, $page, $this->perpage),
            'pagination' => $this->pagination->create_links()
        ];
    }

    private function __read($slug) {
        $article = $this->post->with('ptc')->with('ptt')->get_by('post_slug', $slug);
        if (!empty($article->ptt)) {
            foreach (array_intersect_key($this->tags, $article->ptt) as $tag)
                $meta[] = $tag->tag_content;
        } else {
            $meta = ['Kompas', 'Gramedia', 'Gramedia Majalah', 'GOM', 'Portal GA', 'General Affairs'];
        }
        $this->header['meta'] = implode(', ', $meta);
        return ['article' => $article];
    }

    private function __set_menu() {
        $menu = [
            anchor('portalga#header', 'Home'),
            '<a href="#general_service">General Service</a>',
            '<a href="#procurement">Procurement</a>',
            '<a href="#engineering">Engineering</a>',
            '<a href="#security">Security</a>'
        ];
        return $menu;
    }

}
