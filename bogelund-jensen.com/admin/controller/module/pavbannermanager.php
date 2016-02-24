<?php
/******************************************************
 * @package Pav Banner Manager for Opencart 1.5.x
 * @version 1.0
 * @author pavotheme (http://pavotheme.com)
 * @copyright	Copyright (C) May 2013 pavotheme.com <@emai:pavotheme@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 1
*******************************************************/

class ControllerModulePavbannermanager extends Controller {
	private $error = array();

	public function index() {

		$this->language->load('module/pavbannermanager');
		$this->load->model('setting/setting');
		$this->load->model('tool/image');
		//$this->load->model('pavbannermanager/banner');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('view/javascript/sliderlayer/jquery-cookie.js');

		//$this->document->addStyle(  HTTPS_CATALOG.'catalog/view/theme/default/stylesheet/pavbannermanager/css/bootstrap.css');
		//$this->document->addScript( HTTPS_CATALOG.'catalog/view/theme/default/stylesheet/pavbannermanager/js/bootstrap.js');

		//install data ample
		//$this->model_pavbannermanager_banner->installModule();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$action = isset($this->request->post["action"])?$this->request->post["action"]:"";
			unset($this->request->post['action']);
			if(!empty($this->request->post['pavbannermanager_module'])){
				//foreach($this->request->post['pavbannermanager_module'] as $key=>$module){ }
			}
			
			$this->model_setting_setting->editSetting('pavbannermanager', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			if($action == "save_stay"){
				$this->redirect($this->url->link('module/pavbannermanager', 'token=' . $this->session->data['token'], 'SSL'));
			}else{
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}

		}
		
		

		$this->data['heading_title'] = $this->language->get('heading_banner_title');
		$this->data['tab_module'] = $this->language->get('tab_module');

		// Text
		$this->data['prefix_class'] = $this->language->get('prefix_class');
		// Button
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_save_stay'] = $this->language->get('button_save_stay');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		// Entry
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_tabs'] = $this->language->get('entry_tabs');
		$this->data['entry_banner_layouts'] = $this->language->get('entry_banner_layouts');
		$this->data['entry_caption'] = $this->language->get('entry_caption');
		 

		
		// Value
		$this->data['no_image'] = '';
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');	
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);	
		
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_enabled'] = $this->language->get('text_enabled');


		$this->data['positions'] = array( 'mainmenu',
										  'slideshow',
										  'showcase',
										  'promotion',
										  'content_top',
										  'column_left',
										  'column_right',
										  'content_bottom',
										  'mass_bottom',
										  'footer_top',
										  'footer_center',
										  'footer_bottom');
		$this->data['layout_groups'] = array( 	array('layout_id' => 1, 'name' => $this->language->get('layout_1')),
												array('layout_id' => 2, 'name' => $this->language->get('layout_2')), );
										
		// Token
		$this->data['token'] = $this->session->data['token'];

		// Language
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$this->data['languages'] = $languages;

		$this->load->model('design/layout');

		$this->data['layouts'] = array();
		$this->data['layouts'][] = array('layout_id'=>99999, 'name' => $this->language->get('text_all_page') );
		
		$this->data['layouts'] = array_merge($this->data['layouts'],$this->model_design_layout->getLayouts());

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		//$this->session->data['success'] = $this->language->get('text_success');
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}


		$this->data['action'] = $this->url->link('module/pavbannermanager', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');





		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/pavbannermanager', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		
		$this->data['modules'] = array();
		if (isset($this->request->post['pavbannermanager_module'])) {
			$this->data['modules'] = $this->request->post['pavbannermanager_module'];
		} elseif ($this->config->get('pavbannermanager_module')) { 
			$this->data['modules'] = $this->config->get('pavbannermanager_module');
		}
		
		$d = array(
			'prefix' => 'prefix_class',
			'layout_id'=>'1',
			'position'=>'slideshow',
			'status'=>'',
			'sort_order'=>'2',
			'banner_layout' => '1',
			'banners' => array(),
		);

		if( isset($this->data['modules']) && !empty($this->data['modules']) ){
			$d = array_merge($d,reset($this->data['modules']));			
		}
		if( isset($d['banners']) && !empty($d['banners']) ){
			foreach( $d['banners'] as &$banner ){
				$banner['link'] = isset($banner['link'])?trim($banner['link']):"";
				$banner['thumb'] = $this->model_tool_image->resize($banner['image'], 100, 100);
			}
		}
		
		$this->data['module'] = $d;
		//echo "<pre>"; print_r($this->data['modules']); die;	

		// $this->template = 'module/pavbannermanager/banner_layout.tpl';
		$this->template = 'module/pavbannermanager/modules.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/pavbannermanager')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}



		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
