<?php
/**
 * electrothemebannerlist.php
 * 
 * ControllerExtensionModuleElectrothemebannerlist
 * 
 * Controller for admin panel.
 *  */
class ControllerExtensionModuleElectrothemebannerlist extends Controller
{
		private $error = array();
		/** 
		 * index()
		*/
		public function index() {
			$this->load->language('extension/module/electrothemebannerlist');

			$this->document->setTitle($this->language->get('heading_title'));
			$this->load->model('setting/module');

			if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
				if (!isset($this->request->get['module_id'])) {
					$this->model_setting_module->addModule('electrothemebannerlist', $this->request->post);
				} else {
					$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
				}

				$this->session->data['success'] = $this->language->get('text_success');

				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
			}

			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_extension'),
				'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
			);

			if (!isset($this->request->get['module_id'])) {
				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('heading_title'),
					'href' => $this->url->link('extension/module/electrothemebannerlist', 'user_token=' . $this->session->data['user_token'], true)
				);
			} else {
				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('heading_title'),
					'href' => $this->url->link('extension/module/electrothemebannerlist', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
				);
			}

			if (!isset($this->request->get['module_id'])) {
				$data['action'] = $this->url->link('extension/module/electrothemebannerlist', 'user_token=' . $this->session->data['user_token'], true);
			} else {
				$data['action'] = $this->url->link('extension/module/electrothemebannerlist', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
			}

			$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

			if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
				$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
				
			}

			if (isset($this->request->post['name'])) {
				$data['name'] = $this->request->post['name'];
			} elseif (!empty($module_info)) {
				$data['name'] = $module_info['name'];
			} else {
				$data['name'] = '';
			}

			if (isset($this->request->post['status'])) {
				$data['status'] = $this->request->post['status'];
			} elseif (!empty($module_info)) {
				$data['status'] = $module_info['status'];
			} else {
				$data['status'] = '';
			}

			$this->initActions($data,$module_info);


			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			$this->response->setOutput($this->load->view('extension/module/electrothemebannerlist', $data));
		}


		/**
		 * initActions()
		 * 
		 * @param	$data	a reference to $data array
		 * @param	$module_info	a reference to $module_info array
		 * 
		 * @return	null
		 */
		protected function initActions(&$data,&$module_info){
			
			
			if (isset($this->request->get['item0'])){
				$data['item0']=$this->request->get['item0'];
			} elseif (!empty($module_info)) {
				$data['item0'] = $module_info['item0'];
			} else {
				$data['item0'] = -1;
			}

			if (isset($this->request->get['item1'])){
				$data['item1']=$this->request->get['item1'];
			} elseif (!empty($module_info)) {
				$data['item1'] = $module_info['item1'];
			} else {
				$data['item1'] = -1;
			}

			if (isset($this->request->get['item2'])){
				$data['item2']=$this->request->get['item2'];
			} elseif (!empty($module_info)) {
				$data['item2'] = $module_info['item2'];
			} else {
				$data['item2'] = -1;
			}

			$this->load->model("catalog/category");
			$categories=$this->model_catalog_category->getCategories();
			$data['categories']=array();
			if ($categories){
				foreach ($categories as $cat){
					$data['categories'][]=array(
						'category_id'=>$cat['category_id'],
						'name'=>$cat['name']
					);
				}
			} else {
				$data['categories']=array();
			}

			// Item 0
			if ($data['item0'] == -1){
				$data['banners'][]=array(
					"value"=>"item0",
					"name"=>"Select Category",
					"id" => -1
				);
			} else {
				$name="";
				foreach ($data['categories'] as $category){
					if ($category['category_id'] == $data['item0']){
						$name=$category['name'];
						break;
					}
				}
				$data['banners'][]=array(
					"value"=>"item0",
					"name"=>$name,
					"id" => $data['item0']
				);
			}

			// Item 1
			if ($data['item1'] == -1){
				$data['banners'][]=array(
					"value"=>"item1",
					"name"=>"Select Category",
					"id" => -1
				);
			} else {
				$name="";
				foreach ($data['categories'] as $category){
					if ($category['category_id'] == $data['item1']){
						$name=$category['name'];
						break;
					}
				}
				$data['banners'][]=array(
					"value"=>"item1",
					"name"=>$name,
					"id" => $data['item1']
				);
			}

			// Item 2
			if ($data['item2'] == -1){
				$data['banners'][]=array(
					"value"=>"item2",
					"name"=>"Select Category",
					"id" => -1
				);
			} else {
				$name="";
				foreach ($data['categories'] as $category){
					if ($category['category_id'] == $data['item2']){
						$name=$category['name'];
						break;
					}
				}
				$data['banners'][]=array(
					"value"=>"item2",
					"name"=>$name,
					"id" => $data['item2']
				);
			}
			$data['error_name']='';
		}


}
