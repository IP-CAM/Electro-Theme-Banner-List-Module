<?php
/**
 *  electrothemebannerlist.php
 * 
 *  ModelExtensionModuleElectrothemebannerlist
 * 
 *  Model for a front page.
 */
class ModelExtensionModuleElectrothemebannerlist extends Model
{
  /**
   * getBanners()
   * 
   * @param $setting  the module's settings
   * 
   * @return  $result one-dimensional array of banners
   */
  public function getBanners($setting){
    $this->load->model("catalog/category");

    $items=array(); // array of categories ids
    $items[]=$setting['item0'];
    $items[]=$setting['item1'];
    $items[]=$setting['item2'];

    $result=array();

    $this->load->model('tool/image');

    foreach ($items as $item){

      $i=$this->model_catalog_category->getCategory($item);
      $result[]=array(
        'image' => $i['image']!==''?$this->model_tool_image->resize($i['image'],900,900):
        $this->model_tool_image->resize('placeholder.png',900,900),
        'name' => $i['name'],
        'link' => '/index.php?route=product/category&path='.$i['category_id']
      );

    }
    
    return $result;
  }
}
