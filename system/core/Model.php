<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {
/*
	
	Start Incapsulation of shared methods
	
*/
/*
	Generate pass
*/

//------------------------------------

function getTarifByRoom($roomId){
	$query = $this->db->get_where('mako_ContentTable',array('id'=>$roomId));
	$row = $query->result_array();
	
	$query2 = $this->db->get_where('mako_userTable',array('id'=>$row[0]['userId']));
	$row2 = $query2->result_array();
	//var_dump($row2);
	
	return $row2[0]['tarif'];
}


//---------------------------------------------------------------------
function getCityNameById($id){
	$query = $this->db->get_where('mako_region',array('id_region'=>$id));
	if($query->num_rows()>0){
		$row = $query->result_array();
		return $row[0]['slug'];
	}
}

function getCityIdBySlug($name){
	$query = $this->db->get_where('mako_region',array('slug'=>$name));
	$row = $query->result_array();
	return $row[0]['id_region'];
}

function getCityByParent($user){
	$query = $this->db->get_where('mako_userTable',array('id'=>$user));
	$row = $query->result_array();
	//var_dump($row);
	return $this->getCityNameById($row[0]['city']);
}
function getCityInfoById($id){
	$query = $this->db->get_where('mako_region',array('id_region'=>$id));
	$row = $query->result_array();
	
	return $row[0];
}

function generatePassword($stop=5){
	$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $stop; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}


//---------------------------------------------
function getIDbyEmail($email){
	$query = $this->db->query('SELECT `id` FROM mako_Costumers WHERE email = "'.$email.'"');
	$row = $query->row_array();
	return $row['id'];
}	



//---------------------------------------------
/*
	Model get raspisanie by ID
*/
function getWorkTime($id){
		$this->db->order_by('orderId', 'ASC');
		$query = $this->db->get_where('mako_ParamsTable',array('contentId'=>$id,'type'=>7));
		$rowHour = $query->result_array();
		
		$checkArray = array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7);
		$array = '';
		foreach($rowHour as $rh){
			//$result[$rh['parent']][$rh['orderId']]['hour'] = $rh['value'];
			
			$query = $this->db->get_where('mako_ParamsTable',array('contentId'=>$id,'type'=>8,'parent'=>$rh['parent'], 'orderId'=>$rh['orderId']));
			$rowMinute = $query->result_array();
			
			$query = $this->db->get_where('mako_ParamsTable',array('contentId'=>$id,'type'=>9,'parent'=>$rh['parent'], 'orderId'=>$rh['orderId']));
			$rowCost = $query->result_array();
			
			/*
			$result[(int)$rh['parent']][$rh['orderId']]['min'] = $rowMinute[0]['value'];
			$result[(int)$rh['parent']][$rh['orderId']]['cost'] = $rowCost[0]['value'];
			$result[(int)$rh['parent']][$rh['orderId']]['parent'] = $rh['parent'];
			$result[(int)$rh['parent']][$rh['orderId']]['id'] = $rh['orderId'];
			*/
			//var_dump($rh['parent']);
			
			//$array .='["'.$rh['parent'].'" : "1" ],';
			
			//[{ '.$rh['orderId'].': [{ "hour": '.$rh['value'].', "min": '.$rowMinute[0]['value'].', "cost": '.$rowCost[0]['value'].', parent:'.$rh['parent'].', "id": '.$rh['orderId'].' }] }] ]';
			//$result[$rh['parent']] = 1;
			
			
			$result[$rh['parent']][$rh['orderId']] = array('hour'=>$rh['value'],
											  'min'=>$rowMinute[0]['value'],
											  'cost'=>$rowCost[0]['value'],
											  'parent'=>$rh['parent'],
											  'id'=>$rh['orderId']);
		}
		foreach($checkArray as $key=>$value){
			if(isset($result[$value]) && count($result[$value])>0){
				//$result[$value] = json_encode($result[$value],1);
			}
			else{
				//$array .= '["'.$value.'": "" ],';
				$result[$value] = array();
			}
		}
		
		return $result;
	}


//---------------------------------------------	
/*
	
	Model get params by contentID
	
*/
	function getParam($contentId){
		
		$query = $this->db->query('SELECT * FROM mako_ParamsTable WHERE contentId = "'.$contentId.'" and parent = 0');
		$i = 0;
		if($query->num_rows()>0){
		foreach ($query->result_array() as $row){
	        
	        $result[$i]['paramValue'] = $row['value'];
	        $result[$i]['name'] = $this->getParamNameById($row['type']);
	        $result[$i]['icon'] = $this->getParamIconById($row['type']);
	        $i++;
	        
        }
		return $result;
		}
			 	
	}
//---------------------------------------------	
/*
	
	Model get param name by Id
	
*/
	function getParamNameById($paramId){
		$query = $this->db->query('SELECT `name` FROM mako_ParamTypes WHERE id = "'.$paramId.'"');
		$row = $query->row_array();
		
		return $row['name'];
	}
//---------------------------------------------	
/*
	
	Model get param icon by Id
	
*/
	function getParamIconById($paramId){
		$query = $this->db->query('SELECT `icon` FROM mako_ParamTypes WHERE id = "'.$paramId.'"');
		$row = $query->row_array();
		
		return $row['icon'];
	}
//---------------------------------------------	
/*
	
	Model get addres by Id
	
*/	
	function getAddressByUser($id){
		$query = $this->db->query('SELECT `address` FROM mako_userTable WHERE id = "'.$id.'"');
		$row = $query->row_array();
		
		return $row['address'];
	}
//---------------------------------------------	
function getCostumerById($id){
		$query = $this->db->get_where('mako_Costumers', array('id'=>$id));
		if($query->num_rows()>0){
			$result = $query->result_array();
			return $result[0]['name'];
		}
	}
//---------------------------------------------	
function getUsersByCity($city=1){
		if($city==1){
			$query = $this->db->query('SELECT * FROM mako_userTable');
		}else{
			$query = $this->db->get_where('mako_userTable', array('city' => $city));
		}
		if($query->num_rows()>0){
	       	foreach ($query->result_array() as $row){
		        
		        $result[] = $row;
		        
	        }
	        foreach ($result as $rr){
		        $ids[] = $rr['id'];
	        }
	        return $ids;
        }else{
	        return FALSE;
        }
	}

/*
	
	Model get phone by Id
	
*/	



function getCostumerPhoneByUser($id){
		$query = $this->db->query('SELECT `phone` FROM mako_Costumers WHERE id = "'.$id.'"');
		$row = $query->row_array();
		
		return $row['phone'];
	}

	function getPhoneByUser($id){
		$query = $this->db->query('SELECT `phone` FROM mako_userTable WHERE id = "'.$id.'"');
		$row = $query->row_array();
		
		return $row['phone'];
	}

	
//---------------------------------------------	
/*
	
	Model get map by Id
	
*/	
	function getMapByUser($id){
		$query = $this->db->query('SELECT `map` FROM mako_userTable WHERE id = "'.$id.'"');
		$row = $query->row_array();
		
		return $row['map'];
	}



/*
	
	End Incapsulation of shared methods
	
*/

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		log_message('info', 'Model Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * __get magic
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string	$key
	 */
	public function __get($key)
	{
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your model code.
		return get_instance()->$key;
	}

}
