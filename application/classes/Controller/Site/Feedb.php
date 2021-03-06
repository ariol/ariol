<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site_Feedb extends Controller_Site
{
    public function action_add()
    {
        $this->set_metatags_and_content('', 'page');
        if ($this->request->is_ajax()) {
            $email = $this->request->post('email');
            $name = $this->request->post('name');
            $phone = $this->request->post('phone');
            $text = $this->request->post('text');

            $feedb = ORM::factory('Feedb');
            $feedb->email = $email;
            $feedb->name = $name;
            $feedb->phone = $phone;
            $feedb->text = $text;
            $feedb->save();

            Email::send(Kohana::$config->load('mailer.admin'), array('info@ariol.by', 'Ariol'),
                'Новая заявка в контактах',
                'Имя - '.$name.'<br/>'.
                'Email - '.$email.'<br/>'.
                'Телефон - '.$phone.'<br/>'.
                'Текст письма - '. $text.'<br/>',
                /*html*/true
            );

            exit(json_encode(array()));
        }
        $this->forward_404();
    }
}