<?php
include DIR_APPLICATION . '/view/javascript/DragNDropPosition/compatibility.php';

class ControllerModuleDragNDropPosition extends CompatibilityAdmin {
	const MODULE_VERSION = "v1.4";

	private $error = array();
	private $fields = array(
		'access' => array('default' => '', 'decode' => false, 'required' => true),
		'status' => array('default' => '0', 'decode' => false, 'required' => true),
		'sort' => array('default' => '0', 'decode' => false, 'required' => false),
		'license_key' => array('default' => '', 'decode' => false, 'required' => false),
		'license' => array('default' => '', 'decode' => false, 'required' => false)
	);

	public function index() {
		$data = array_merge(array(), $this->language->load('module/dragndrop_position'));

		$this->loadStyles('DragNDropPosition');

		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title') . ' ' . self::MODULE_VERSION;

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSetting()) {
			$this->editSetting('dragndrop_position', $this->request->post['dragndrop_position'], 0);

			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirectTo('module/dragndrop_position');
		}

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['error'])) {
			$data['error'] = $this->error['error'];
		} else {
			$data['error'] = array();
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['action'] = $this->url->link('module/dragndrop_position', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$config_store = $this->getSetting('dragndrop_position', 0);

		foreach ($this->fields as $key => $value) {
			if (isset($this->request->post['dragndrop_position'][$key])) {
				$data[$key] = $this->request->post['dragndrop_position'][$key];
			} elseif (isset($config_store[$key])) {
				$data[$key] = $config_store[$key];
			} else {
				if ($value['decode']) {
					$value['default'] = base64_decode($value['default']);
				}

				$data[$key] = $value['default'];
			}
		}

		$this->load->model('user/user');

		$data['users'] = $this->model_user_user->getUsers(array('start' => 0, 'limit' => 9999));

		$this->toOutput('module/dragndrop_position.tpl', $data);
	}

	public function position() {
		$json = array();

		$this->language->load('module/dragndrop_position');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->post['order']) || !$this->request->post['order']) {
				$json['success'] = $this->language->get('error_params');
			} else {
				if (in_array($this->request->post['module'], array('payment', 'shipping', 'total'))) {
					if (version_compare(VERSION, '2.0') < 0) {
						$this->load->model('setting/extension');

						$extensions = $this->model_setting_extension->getInstalled($this->request->post['module']);
					} else {
						$this->load->model('extension/extension');

						$extensions = $this->model_extension_extension->getInstalled($this->request->post['module']);
					}

					foreach ($extensions as $key => $value) {
						if (!file_exists(DIR_APPLICATION . 'controller/' . $this->request->post['module'] . '/' . $value . '.php')) {
							unset($extensions[$key]);
						}
					}

					foreach ($this->request->post['order'] as $key => $value) {
						if (in_array($key, $extensions)) {
							$query = $this->db->query("SELECT `key` FROM " . DB_PREFIX . "setting WHERE `" . (version_compare(VERSION, '2.0.1') < 0 ? 'group' : 'code') . "` = '" . $this->db->escape($key) . "' AND (`key` = '" . $this->db->escape($key) . "_sort_order' OR `key` LIKE '%_sort_order') AND serialized = '0'");

							if ($query->num_rows) {
								$this->db->query("UPDATE " . DB_PREFIX . "setting SET value = '" . (int)$value . "' WHERE `" . (version_compare(VERSION, '2.0.1') < 0 ? 'group' : 'code') . "` = '" . $this->db->escape($key) . "' AND `key` = '" . $this->db->escape($query->row['key']) . "'");
							}
						}
					}
				} elseif ($this->request->post['module'] == 'product') {
					foreach ($this->request->post['order'] as $key => $value) {
						$this->db->query("UPDATE " . DB_PREFIX . "product SET sort_order = '" . (int)$value . "' WHERE product_id = '" . (int)$key . "'");
					}

					$this->cache->delete('product');
				} elseif ($this->request->post['module'] == 'attribute_group') {
					foreach ($this->request->post['order'] as $key => $value) {
						$this->db->query("UPDATE " . DB_PREFIX . "attribute_group SET sort_order = '" . (int)$value . "' WHERE attribute_group_id = '" . (int)$key . "'");
					}
				} elseif ($this->request->post['module'] == 'attribute') {
					foreach ($this->request->post['order'] as $key => $value) {
						$this->db->query("UPDATE " . DB_PREFIX . "attribute SET sort_order = '" . (int)$value . "' WHERE attribute_id = '" . (int)$key . "'");
					}
				} elseif ($this->request->post['module'] == 'option') {
					foreach ($this->request->post['order'] as $key => $value) {
						$this->db->query("UPDATE " . DB_PREFIX . "option SET sort_order = '" . (int)$value . "' WHERE option_id = '" . (int)$key . "'");
					}
				} elseif ($this->request->post['module'] == 'category') {
					foreach ($this->request->post['order'] as $key => $value) {
						$this->db->query("UPDATE " . DB_PREFIX . "category SET sort_order = '" . (int)$value . "' WHERE category_id = '" . (int)$key . "'");
					}

					$this->cache->delete('category');
				} elseif ($this->request->post['module'] == 'manufacturer') {
					foreach ($this->request->post['order'] as $key => $value) {
						$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET sort_order = '" . (int)$value . "' WHERE manufacturer_id = '" . (int)$key . "'");
					}

					$this->cache->delete('manufacturer');
				} elseif ($this->request->post['module'] == 'information') {
					foreach ($this->request->post['order'] as $key => $value) {
						$this->db->query("UPDATE " . DB_PREFIX . "information SET sort_order = '" . (int)$value . "' WHERE information_id = '" . (int)$key . "'");
					}

					$this->cache->delete('information');
				} elseif ($this->request->post['module'] == 'customer_group') {
					foreach ($this->request->post['order'] as $key => $value) {
						$this->db->query("UPDATE " . DB_PREFIX . "customer_group SET sort_order = '" . (int)$value . "' WHERE customer_group_id = '" . (int)$key . "'");
					}
				} elseif ($this->request->post['module'] == 'language') {
					foreach ($this->request->post['order'] as $key => $value) {
						$this->db->query("UPDATE " . DB_PREFIX . "language SET sort_order = '" . (int)$value . "' WHERE language_id = '" . (int)$key . "'");
					}

					$this->cache->delete('language');
				}
			}

			$json['success'] = $this->language->get('text_success_position');
		} else {
			$json['error'] = $this->language->get('error_permission');
		}

		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/dragndrop_position')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->config->get('dragndrop_position_status')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->config->get('dragndrop_position_access') || !in_array($this->user->getId(), (array)$this->config->get('dragndrop_position_access'))) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateSetting() {
		if (!$this->user->hasPermission('modify', 'module/dragndrop_position')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ($this->request->post['dragndrop_position']) {
			foreach ($this->fields as $key => $value) {
				if ($value['required'] && (!isset($this->request->post['dragndrop_position'][$key]) || $this->request->post['dragndrop_position'][$key] === null)) {
					$this->error['error'][$key] = $this->language->get('error_' . $key);
				}
			}

			if (isset($this->error['error'])) {
				$this->error['warning'] = $this->language->get('error_required');
			}
		} else {
			$this->error['warning'] = $this->language->get('error_module');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	public function install() {
		$settings = $this->getSetting('dragndrop_position', 0);
		$settings['dragndrop_position']['status'] = 1;
		$this->editSetting('dragndrop_position', $settings['dragndrop_position'], 0);

		$query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_attribute LIKE 'sort_order'");

		if (!$query->row) {
			$this->db->query("ALTER TABLE  " . DB_PREFIX . "product_attribute ADD sort_order INT(11) NOT NULL DEFAULT '0'");
		}

		$query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_option_value LIKE 'sort_order'");

		if (!$query->row) {
			$this->db->query("ALTER TABLE  " . DB_PREFIX . "product_option_value ADD sort_order INT(11) NOT NULL DEFAULT '0'");
		}
	}

	public function uninstall() {
		$settings = $this->getSetting('dragndrop_position', 0);
		$settings['dragndrop_position']['status'] = 0;
		$this->editSetting('dragndrop_position', $settings['dragndrop_position'], 0);

		$this->db->query("ALTER TABLE " . DB_PREFIX . "product_attribute DROP COLUMN sort_order");
		$this->db->query("ALTER TABLE " . DB_PREFIX . "product_option_value DROP COLUMN sort_order");
	}
}
?>