<?php
final class Document {
	private $title;
	private $description;
	private $title_og;
	private $description_og;
	private $image_og;
	private $keywords;
	private $links = array();
	private $styles = array();
	private $scripts = array();

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setImageog($image) {
		$this->image_og = $image;
	}

	public function getImageog() {
		return $this->image_og;
	}

	public function setTitleog($title) {
		$this->title_og = $title;
	}

	public function getTitleog() {
		return $this->title_og;
	}

	public function setDescriptionog($description) {
		$this->description_og = $description;
	}

	public function getDescriptionog() {
		return $this->description_og;
	}

	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	public function getKeywords() {
		return $this->keywords;
	}

	public function addLink($href, $rel) {
		$this->links[] = array(
		                       'href' => $href,
		                       'rel'  => $rel
		                       );
	}

	public function getLinks() {
		return ($this->links);//array_unique
	}

	public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
		$this->styles[] = array(
		                        'href'  => $href,
		                        'rel'   => $rel,
		                        'media' => $media
		                        );
	}

	public function getStyles() {
		return array_unique($this->styles);
	}

	public function addScript($script) {
		$this->scripts[] = $script;
	}

	public function getScripts() {
		return array_unique($this->scripts);
	}
}
?>