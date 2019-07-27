<?php
/**
 * electrothemebannerlist.php
 * 
 * ControllerExtensionModuleElectrothemebannerlist
 * 
 * Controller for a front page.
 *  */
class ControllerExtensionModuleElectrothemebannerlist extends Controller
{
	public function index($setting)
	{
		$this->load->language('extension/module/electrothemebannerlist');

		$this->load->model('extension/module/electrothemebannerlist');

		$data=array();

		$data['banners']=$this->model_extension_module_electrothemebannerlist->getBanners($setting);
		
		return $this->load->view('extension/module/electrothemebannerlist', $data);
	}
}
