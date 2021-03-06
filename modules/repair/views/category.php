<?php
/**
 * @filesource modules/repair/views/category.php
 * @link http://www.kotchasan.com/
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 */

namespace Repair\Category;

use \Kotchasan\Html;

/**
 * module=repair-category
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{

  /**
   * รายการหมวดหมู่
   *
   * @param object $index
   * @return string
   */
  public function render($index)
  {
    // form
    $form = Html::create('form', array(
        'id' => 'setup_frm',
        'class' => 'setup_frm',
    ));
    $fieldset = $form->add('fieldset', array(
      'title' => '{LNG_Details of} '.$index->categories[$index->group_id]
    ));
    $list = $fieldset->add('ul', array(
      'class' => 'editinplace_list',
      'id' => 'list'
    ));
    foreach (\Repair\Category\Model::all($index->group_id) as $item) {
      $list->appendChild(self::createRow($item));
    }
    $fieldset = $form->add('fieldset', array(
      'class' => 'submit'
    ));
    $a = $fieldset->add('a', array(
      'class' => 'button add large',
      'id' => 'list_add_0_'.$index->group_id
    ));
    $a->add('span', array(
      'class' => 'icon-plus',
      'innerHTML' => '{LNG_Add New} '.$index->categories[$index->group_id]
    ));
    $form->script('initEditInplace("list", "repair/model/category/action", "list_add_0_'.$index->group_id.'");');
    return $form->render();
  }

  /**
   * ฟังก์ชั่นสร้างแถวของรายการหมวดหมู่
   *
   * @param array $item
   * @return string
   */
  public static function createRow($item)
  {
    $id = $item['id'].'_'.$item['group_id'];
    $row = '<li class="row" id="list_'.$id.'">';
    $row .= '<div class="no">['.$item['id'].']</div>';
    $row .= '<div><span id="list_name_'.$id.'" title="{LNG_click to edit}">'.$item['topic'].'</span></div>';
    $row .= '<div class="right">';
    $row .= '<span id="list_published_'.$id.'" class="icon-published'.$item['published'].'"></span>';
    if ($item['group_id'] == 1) {
      $row .= '<label><input type="radio" name="repair_first_status" id="list_status_'.$id.'" title="{LNG_Initial repair status}" value="'.$item['id'].'"'.(isset(self::$cfg->repair_first_status) && self::$cfg->repair_first_status == $item['id'] ? ' checked' : '').'></label>';
      $row .= '<span id="list_color_'.$id.'" class="icon-color" title="'.$item['color'].'"></span>';
    }
    $row .= '<span id="list_delete_'.$id.'" class="icon-delete" title="{LNG_Delete}"></span>';
    $row .= '</div>';
    $row .= '</li>';
    return $row;
  }
}
