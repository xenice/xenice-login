<?php
/**
 * @name        xenice options
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-09-26
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\login;

class Config extends Options
{
    protected $key = 'login';
    protected $name = ''; // Database option name
    protected $defaults = [];
    
    public function __construct()
    {
        $this->name = 'xenice_' . $this->key;
        $this->defaults[] = [
            'id'=>'login',
            'name'=> __('Login', 'xenice-login'),
            'submit'=>__('Save Chanages', 'xenice-login'),
            'title'=> __('Login Settings', 'xenice-login'),
            'tabs' => [
                 [
                    'id' => 'general',
                    'title' => __('General', 'xenice-login'),
                    'fields'=>[
                        [
                            'id'   => 'display_color',
                            'name' => __('Display Color', 'xenice-login'),
                            'type'  => 'radio',
                            'value'=>'',
                            'opts' =>[
                                ''=>__('Default','xenice-login'),
                                '#0099FF #007bff #99CCFF' => __('Blue','xenice-login'),
                                '#FF5E52 #f13c2f #fc938b' => __('Red','xenice-login'),
                                '#1fae67 #229e60 #35dc89' => __('Green','xenice-login'),
                                '#ff4979 #f2295e #fb94af' => __('Pink','xenice-login'),
                            ]
                            
                        ],
                        [
                            'id'   => 'disable_bootstrap_lib',
                            'name'  => __('Disable bootstrap library', 'xenice-login'),
                            'type'  => 'checkbox',
                            'value' => false,
                            'label'  => __('Disable', 'xenice-login')
                        ],
                        [
                            'id'   => 'static_lib_cdn',
                            'type'  => 'select',
                            'name' => __('Static library CDN', 'xenice-login'),
                            'value' => '',
                            'opts' => [
                                ''=>__('Default', 'xenice-login'),
                                'https://cdn.staticfile.org'=>'https://cdn.staticfile.org',
                                'https://cdn.bootcdn.net/ajax/libs'=>'https://cdn.bootcdn.net/ajax/libs',
                                'https://libs.cdnjs.net'=>'https://libs.cdnjs.net',
                            ]
                        ],
                    ]
                ], // #General
                [
                    'id' => 'modal',
                    'title' => __('Modal', 'xenice-login'),
                    'fields'=>[
                        [
                            'id'   => 'enable_login_modal',
                            'name'  => __('Login Modal', 'xenice-login'),
                            'type'  => 'checkbox',
                            'value' => true,
                            'label'  => __('Enable', 'xenice-login')
                        ],
                        [
                            'id'   => 'modal_width',
                            'name' => __('Modal Width', 'xenice-login'),
                            'type'  => 'radio',
                            'value'=>'400px',
                            'opts' =>[
                                '330px' =>'330px',
                                '400px' => '400px',
                            ]
                            
                        ],
                        
                    ]
                ], // #login_modal
                /*
                 [
                    'id' => 'social_login',
                    'title' => __('Social login', 'xenice-login'),
                    'fields'=>[
                        [
                            'name' => __('QQ Login', 'xenice-login'),
                            'desc' => sprintf(__('<a href="%s" target="_blank">Register</a> a QQ social login account. <a onclick="xenice_login_copy(this);return false;" href="%s?action=qqCallback">Copy</a> the callback url.', 'xenice-login'),'https://connect.qq.com/',admin_url('admin-ajax.php')),
                            'fields'=>[
                                [
                                    'id'   => 'enable_qq_login',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => __('Enable', 'xenice-login')
                                ],
                                [
                                    'id'   => 'qq_app_id',
                                    'type'  => 'text',
                                    'value' => '',
                                    'label'  => __('APP ID', 'xenice-login')
                                ],
                                [
                                    'id'   => 'qq_app_key',
                                    'type'  => 'text',
                                    'value' => '',
                                    'label'  => __('APP Key', 'xenice-login')
                                ],
                            ]  
                        ],
                        [
                            'name' => __('WeChat Login', 'xenice-login'),
                            'desc' => sprintf(__('<a href="%s" target="_blank">Register</a> a WeChat social login account. <a onclick="xenice_login_copy(this);return false;" href="%s?action=wechatCallback">Copy</a> the callback url.', 'xenice-login'),'https://open.weixin.qq.com/',admin_url('admin-ajax.php')),
                            'fields'=>[
                                [
                                    'id'   => 'enable_wechat_login',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => __('Enable', 'xenice-login')
                                ],
                                [
                                    'id'   => 'wechat_app_id',
                                    'type'  => 'text',
                                    'value' => '',
                                    'label'  => __('APP ID', 'xenice-login')
                                ],
                                [
                                    'id'   => 'wechat_app_secret',
                                    'type'  => 'text',
                                    'value' => '',
                                    'label'  => __('APP Secret', 'xenice-login')
                                ],
                            ]  
                        ],
                        [
                            'name' => __('WeiBo Login', 'xenice-login'),
                            'desc' => sprintf(__('<a href="%s" target="_blank">Register</a> a WeiBo social login account. <a onclick="xenice_login_copy(this);return false;" href="%s?action=weiboCallback">Copy</a> the callback url.', 'xenice-login'),'http://open.weibo.com',admin_url('admin-ajax.php')),
                            'fields'=>[
                                [
                                    'id'   => 'enable_weibo_login',
                                    'type'  => 'checkbox',
                                    'value' => false,
                                    'label'  => __('Enable', 'xenice-login')
                                ],
                                [
                                    'id'   => 'weibo_app_id',
                                    'type'  => 'text',
                                    'value' => '',
                                    'label'  => __('APP Key', 'xenice-login')
                                ],
                                [
                                    'id'   => 'weibo_app_key',
                                    'type'  => 'text',
                                    'value' => '',
                                    'label'  => __('APP Secret', 'xenice-login')
                                ],
                            ]  
                        ],
                    ]
                ],*/
            ]
            
        ];
	    parent::__construct();
    }
    
    /**
     * update options
     */
     /*
    public function update($id, $tab, $fields)
    {
        if($key == 'mail' && $tab == 1){
            global $current_user;
            //$bool = wp_mail($current_user->user_email, $fields['mail_title']??'', $fields['mail_content']??'');
            $bool = true;
            if($bool)
                $result = ['key'=>$id, 'return' => 'success', 'message'=>__('Send successfully', 'xenice-mail')];
            else
                $result = ['key'=>$id, 'return' => 'error', 'message'=>__('Send failure', 'xenice-mail')];
            Theme::call('xenice_options_result', $result);
        }
        else{
            parent::update($id, $tab, $fields);
        }
        
       
    }*/


}