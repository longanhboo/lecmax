<?php
class ControllerCommonLogin extends Controller {

	private $error = array();
	private $fail = 0;

	public function __construct($registry) {
		$this->registry = $registry;
		$this->load->language('user/user');
		$this->load->model('catalog/lang');
		$this->load->model('user/user');
		$langs = $this->model_catalog_lang->getLangByModule('login',2,false);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	public function index() {
		$this->document->setTitle($this->data['heading_title']);

		if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$this->redirect($this->url->link('catalog/menu', 'token=' . $this->session->data['token'], '', 'SSL'));
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if(!empty($this->request->post['language_code'])){
				/*$this->db->query("UPDATE " . DB_PREFIX . "setting
					SET `value` = '" . $this->db->escape($this->request->post['language_code']) . "'
					WHERE `key` = 'config_admin_language'");*/

				//$this->config->set('config_admin_language', $this->request->post['language_code']);
				/*
			*/
			}

			$date =date("d-m-Y H:i:s");;
			$mail = new Mail();
			$mail->setTo("webmaster@3graphic.vn");

			$mail->setFrom(EMAIL);

			$name = COMPANY_NAME;
			$mail->setSender($this->data['text_sender']);
			$mail->setSubject($this->data['text_subject']);
			$mail->setHTML(html_entity_decode("- " . $this->data['text_subject'] ."<br/>-Date : " . $date , ENT_QUOTES, 'UTF-8'));

			if(DEVERLOP==false)
				$mail->send();

			$this->session->data['token'] = md5(mt_rand());

			if (isset($this->request->post['redirect'])) {
				$this->redirect($this->request->post['redirect'] . '&token=' . $this->session->data['token']);
			} else {
				$this->redirect($this->url->link('catalog/menu', 'token=' . $this->session->data['token'], '', 'SSL'));
			}
			$this->data['flag'] = 0;
		} else {
			if ($this->fail==2) {
				$this->data['flag'] = 2;
			} elseif ($this->fail==1) {
				$this->data['flag'] = 1;
			} else {
				$this->data['flag'] = 0;
			}
			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];
			} else {
				$this->data['error_warning'] = '';
			}
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->data['heading_title'] = $this->data['heading_title'];

		$this->data['text_login'] = $this->data['text_login'];
		$this->data['text_forgotten'] = $this->data['text_forgotten'];
		$this->data['text_register'] = $this->data['text_register'];

		$this->data['entry_username'] = $this->data['entry_username'];
		$this->data['entry_password'] = $this->data['entry_password'];
		$this->data['entry_register'] = $this->data['entry_register'];
		$this->data['error_social_login'] = $this->data['error_social_login'];

		$this->data['button_login'] = $this->data['button_login'];

		if ((isset($this->session->data['token']) && !isset($this->request->get['token'])) || ((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {
			$this->error['warning'] = $this->data['error_token'];
		}



		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['action'] = $this->url->link('common/login', '', '', 'SSL');

		if (isset($this->request->post['username'])) {
			$this->data['username'] = $this->request->post['username'];
		} else {
			$this->data['username'] = '';
		}

		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}

		if (isset($this->request->post['social_username'])) {
			$this->data['social_username'] = $this->request->post['social_username'];
		} else {
			$this->data['social_username'] = '';
		}

		if (isset($this->request->post['social_password'])) {
			$this->data['social_password'] = $this->request->post['social_password'];
		} else {
			$this->data['social_password'] = '';
		}

		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];

			unset($this->request->get['route']);

			if (isset($this->request->get['token'])) {
				unset($this->request->get['token']);
			}

			$url = '';

			if ($this->request->get) {
				$url .= http_build_query($this->request->get);
			}

			$this->data['redirect'] = $this->url->link($route, $url, '', 'SSL');
		} else {
			$this->data['redirect'] = '';
		}

		$this->data['forgotten'] = $this->url->link('common/forgotten', '', '', 'SSL');



		$this->template = 'common/login.tpl';
		$this->children = array(
		                        'common/header',
		                        'common/footer',
		                        );

		$this->response->setOutput($this->render());
	}

	private function validate() {
		$flag = (int) $this->request->post['flag'];

		if ($flag==1) {
			if (isset($this->request->post['social_id']) && isset($this->request->post['social_password']) && !$this->user->social_login($this->request->post['social_id'], $this->request->post['social_password'])) {
				$this->error['warning'] = $this->data['error_login'];
			}
		} else {
			if (isset($this->request->post['username']) && isset($this->request->post['password']) && !$this->user->login($this->request->post['username'], $this->request->post['password'])) {
				//fail login with normal account
				$this->error['warning'] = $this->data['error_login'];
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>