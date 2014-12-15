<?php defined('SYSPATH') or die('No direct script access.');

class Model_News extends ORM
{
    protected $_table_name = 'news';

	protected $_belongs_to = array(
		'category' => array(
            'model'       => 'News_Category',
            'foreign_key' => 'category_id',
        )
	);
	
	public function labels()
    {
        return array(
			'id' => 'Идентификатор',
			'name' => 'Наименование',
            'main_image' => 'Главное изображение',
			's_title' => 'SEO title',
			's_description' => 'SEO description',
			's_keywords' => 'SEO keywords',
			'content' => 'Контент',
			'short_content' => 'Сокращенный контент',
			'category' => 'Категория',
			'category_id' => 'Категория',
			'active' => 'Активность',
			'url' => 'URL',
			'created_at' => 'Дата публикации'
        );
    }
	
	public function form()
    {
        return new Form_Admin_News($this);
    }

	public function save($validation)
	{
        $this->md5_url = md5($this->url);

		parent::save($validation);

		if (!$this->created_at) {
			$this->created_at = date('Y-m-d');
			$this->save($validation);
		}
	}
	
	protected $_grid_columns = array(
		//'id' => null,
		'name' => null,
		'category_id' => array(
			'type' => 'template',
			'template' => '${category_name}'
		),
		'created_at' => null,
		'edit' => array(
			'width' => '40',
			'type' => 'link',
			'route_str' => 'admin-news:edit?id=${id}',
			'title' => '<i class="fa fa-edit"></i>',
			'color' => 'green',
			'alternative' => 'Редактировать'
		),
        'delete' => array(
            'width' => '40',
            'type' => 'link',
            'route_str' => 'admin-news:delete?id=${id}',
            'title' => '<i class="fa fa-trash-o"></i>',
            'alternative' => 'Удалить',
			'color' => 'red',
            'confirm' => 'Вы уверены?'
        )
    );
	
	public function get_category_name()
	{
		return $this->category->name;
	}

    public function sortable_fields()
    {
        return array(
            'name',
            'category_id'
        );
    }
}