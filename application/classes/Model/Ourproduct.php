<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ourproduct extends ORM
{
    protected $_table_name = 'ourproducts';

    protected $_belongs_to = array(
        'category' => array(
            'model'       => 'Ourproduct_Category',
            'foreign_key' => 'category_id',
        )
    );

    public function labels()
    {
        return array(
            'id' => 'Идентификатор',
            'name' => 'Наименование',
            'category_id' => 'Категория',
            'position' => 'Позиция',
            'url' => 'Ссылка на описание работы',
            'link' => 'Ссылка на сайт',
            'active' => 'Активность',
            'on_main' => 'На главной',
            'image' => 'Изображение',
            'more_image' => 'Дополнительные изображения',
            'short_content' => 'Сокращенный контент',
            'content' => 'Контент'
        );
    }

    public function form()
    {
        return new Form_Admin_Ourproduct($this);
    }

    public function save($validation)
    {
        $this->md5_url = md5($this->url);

        parent::save($validation);

    }

    protected $_grid_columns = array(
        'name' => null,
        'category_id' => array(
            'type' => 'template',
            'template' => '${category_name}'
        ),
        'position' => null,
        'on_main' => null,
        'active' => null,
        'edit' => array(
            'width' => '40',
            'type' => 'link',
            'route_str' => 'admin-ourproduct:edit?id=${id}',
            'title' => '<i class="fa fa-edit"></i>',
            'color' => 'green',
            'alternative' => 'Редактировать'
        ),
        'delete' => array(
            'width' => '40',
            'type' => 'link',
            'route_str' => 'admin-ourproduct:delete?id=${id}',
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
            'category_id',
            'on_main',
            'position',
            'active'
        );
    }
}