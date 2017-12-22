<?php
/**
*line_wrapping_parse
*
* Генерируем вывод по шаблону из текста, разделенного переносами строк
*
* @category  parser
* @version 1.0.0
* @license     GNU General Public License (GPL), http://www.gnu.org/copyleft/gpl.html
* @param int $docid ID документа
* @param string $field название(имя) tv-параметра
* @param string $tpl название чанка с шаблоном вывода
* @return string Значение поля TV параметра с разбиением по переносам и выводом в соответствии с шаблоном
 @example
*       [[line_wrapping_parse? &docid=`15` &field=`spismetro` &tpl=`spismetro_tpl`]]
* {{spismetro_tpl}} <option value="[+value+]">[+value+]</option>
*/
$docid=(isset($docid)) ? $docid: $modx -> documentObject['docid'];	//id документа с нужными параметрами
$field=(isset($field)) ? $docid: $modx -> documentObject['field'];	//название tv-параметра, из которого необходимо получить информацию
$tpl = (isset($tpl)) ? $tpl: $modx -> documentObject['tpl'];	//Название чанка с шаблоном вывода

$tv_val = $modx->getTemplateVar($field,'*',$docid);
$original_str = ($tv_val['value']!='') ? $tv_val['value'] : $tv_val['defaultText'];

if (isset($original_str) && !empty($original_str)) {
	if(isset($tpl) && !empty($tpl)){
		$data_arr = explode(PHP_EOL, $original_str);//Разбиваем массив и делаем переносы
		if(isset($data_arr) && !empty($data_arr)){
			$return_data = '';
			foreach($data_arr as $data_value){
				$replasement_data = $modx->parseChunk($tpl, array( 'value' => $data_value), '[+', '+]' );
				$return_data.=$replasement_data.PHP_EOL;
			}
			return $return_data;
		}
	}else{
		return $original_str;
	}
}
