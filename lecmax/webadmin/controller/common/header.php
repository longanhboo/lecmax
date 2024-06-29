<?php
class ControllerCommonHeader extends Controller {
	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('header',2,false);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}

	}

	protected function index() {
		$this->data['title'] = $this->document->getTitle();

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->data['code'];
		//$this->data['direction'] = $this->language->get('direction');

		$this->data['heading_title'] = $this->data['heading_title'];

		$this->data['text_front'] = $this->data['text_front'];

		$this->data['text_logout'] = $this->data['text_logout'];

		$this->data['text_confirm'] = $this->data['text_confirm'];

		if (!$this->user->isLogged() || !isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
			$this->data['logged'] = '';

			$this->data['home'] = $this->url->link('common/login', '', '', 'SSL');
		} else {
			$this->data['superadmin'] = false;

			if($this->user->getId()==1){
				$this->data['superadmin'] = true;
				$this->data['text_superadmin'] = $this->data['text_superadmin'];
				$this->data['text_admin_menu'] = $this->data['text_admin_menu'];
				$this->data['text_permission'] = $this->data['text_permission'];
				$this->data['text_install']    = $this->data['text_install'];
				$this->data['text_install_cate']    = $this->data['text_install_cate'];
				$this->data['text_uninstall']    = $this->data['text_uninstall'];

				$this->data['install_cate'] = $this->url->link('catalog/installcate', 'token=' . $this->session->data['token'], '', 'SSL');
				$this->data['install'] = $this->url->link('catalog/install', 'token=' . $this->session->data['token'], '', 'SSL');
				$this->data['uninstall'] = $this->url->link('catalog/uninstall', 'token=' . $this->session->data['token'], '', 'SSL');
				$this->data['adminmenu'] = $this->url->link('catalog/adminmenu', 'token=' . $this->session->data['token'], '', 'SSL');
				$this->data['translatebackend'] = $this->url->link('catalog/lang', 'token=' . $this->session->data['token'] . '&frontend=2', '', 'SSL');
				$this->data['permission'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], '', 'SSL');
			}

			/*========================*/
			$this->data['token'] = $this->session->data['token'];

			$this->load->model('catalog/adminmenu');
			$menus = $this->model_catalog_adminmenu->getMenus(0);

			$this->data['strmenu'] = $this->menuHTML($menus);

			$this->data['logged'] = sprintf($this->data['text_logged'], $this->user->getUserName());

			$this->data['front_end'] = HTTP_CATALOG;

			$this->data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], '', 'SSL');

		}

		if(isset($this->request->get['ajax']) && $this->request->get['ajax'])
			$this->template = 'common/header_ajax.tpl';
		else
			$this->template = 'common/header.tpl';

		$this->render();
	}

	private function checkPermission($item){
		if($this->user->getId()==1)
			return false;

		$tmp = explode('&', $item['path']);
		$tmp = explode('/', $tmp[0]);
		$route = $tmp[0];
		if(isset($tmp[1]))
			$route .= '/' . $tmp[1];

		$ignore = array(
		                'null'
		                );

		if(!in_array($route, $ignore) && !$this->user->hasPermission('access',$route))
			return true;

		if($route=='null'){
			foreach($item['child'] as $rs){
				if(!$this->checkPermission($rs))
					return false;
			}
			return true;
		}
		return false;
	}

	private function menuHTML($menus){
		$strHTML='';
		//print_r($menus);

		foreach($menus as $item){
			if($this->checkPermission($item))
				continue;

			$href = '';
			$cls = '';
			$id = '';
			$target = '';

			if($item['parent_id']==0){
				if ($item['child']) {
					$cls = ' class="parent" ';
				}

				$id = 'id="menu-' . $item['id'] . '"';
			}
			
			if ($item['child']) {
				$cls = ' class="parent" ';
			}

			if(!$item['child']){
				if(isset($item['id']) && $item['id']==138){
					$href = ' href="' . str_replace('webadmin','designtool/cpanelogin',$this->url->link($item['path'], 'token=' . $this->session->data['token'], '', 'SSL')) . '" ';
					$target = ' target="_black"';
				}else{
					$href = ' href="' . $this->url->link($item['path'], 'token=' . $this->session->data['token'], '', 'SSL') . '" ';
				}
			}

			if (isset($item['id']) && intval($item['id'])==86) {
				foreach ($item['child'] as $child) {
					$cls = '';
					if (!$child['child']) {
						$href = ' href="' . $this->url->link($child['path'], 'token=' . $this->session->data['token'], '', 'SSL') . '" ';
					}
					$strHTML .= '<li ' . $id . '><a ' . $cls . $href  . $target  . '><i class="fa fa-puzzle-piece fa-fw"></i><span>' . (($child['parent_id']==0)? mb_strtoupper($child['name'], 'utf8') : $child['name']) . (($child['parent_id']==0) ? '</span>' : '') . '</a></li>';

				}
			} else {
				if($item['id']!=1 && $item['id']!=378 ){//&& $item['id']!=265
				$strHTML .= '<li ' . $id . '><a ' . $cls . $href . $target . '>' . (($item['parent_id']==0 && $item['id']==66) ? '<i class="fa fa-cog fa-fw"></i><span>' : '') . (($item['parent_id']==0 && $item['id']!=66 ) ? '<i class="fa fa-puzzle-piece fa-fw"></i><span>' : '') . (($item['parent_id']==0)? ($item['id']==86) ? $item['child'][0]['name'] : mb_strtoupper($item['name'], 'utf8') : $item['name']) . (($item['parent_id']==0) ? '</span>' : '') . '</a>' . ((empty($item['child']) || $item['id']==86)?'': '<ul>'. $this->menuHTML($item['child']) .'</ul>' ) . '</li>';
				}
			}
		}
		return $strHTML;
	}
}
?>