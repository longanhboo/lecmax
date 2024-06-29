<?php
class ControllerCommonFooter extends Controller {
	public function __construct($registry) {
		$this->registry = $registry;

		$this->load->model('catalog/lang');

		$langs = $this->model_catalog_lang->getLangByModule('footer',2,false);
		foreach($langs as $lang){
			$this->data[$lang['key']] = html_entity_decode($lang['name']);
		}
	}

	protected function index() {
		//$this->load->model('catalog/useronline');

		// $userOnline=$this->model_catalog_useronline->count_users();
		// $countUser =$this->model_catalog_useronline->count_all_access();

		// $this->data['userOnline'] = $userOnline;
		// $this->data['countUser'] = $countUser;


		// $this->data['text_visit'] = $this->data['text_visit'];
		// $this->data['text_online'] = $this->data['text_online'];
		// $this->data['text_website_name'] = $this->data['text_website_name'];

		$this->data['text_footer'] = sprintf($this->data['text_footer'], VERSION);

		$this->data['islogin'] = false;
		if($this->user->getId()>0)
			$this->data['islogin'] = true;

		if(isset($this->request->get['ajax']) && $this->request->get['ajax'])
			$this->template = 'common/footer_ajax.tpl';
		else
			$this->template = 'common/footer.tpl';

		$this->render();
	}
}
?>