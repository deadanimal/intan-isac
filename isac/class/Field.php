<?php
require_once('HTML.php');
/**
* class Field
*/
class Field extends HTML
{
	//=====class members declaration================
	//attribute
	private $cols;				//cols (textarea)
	private $label;				//label value
	private $labelfor;			//for (label)
	private $maxlength;			//maxlength
	private $name;				//name
	private $option;			//option (array of value and label)
	private $rows;				//rows (textarea)
	private $size;				//size
	private $selected;			//selected (string for normal select/ array for multiple select)
	private $tabindex;			//tabindex
	private $type;				//type
	private $value;				//value
	
	//status
	private $checked;			//checked	(checkbox, radio)
	private $disabled;			//disabled
	private $multiple;			//multiple	(select)
	private $readonly;			//readonly
	
	//=====class functions =========================
	//set table's attribute
	public function setAttribute($attribute,$value)
	{
		switch(strtolower($attribute))
		{
			case 'cols'			: $this->cols = $value;
				break;
			case 'for'			: $this->labelfor = $value;
				break;
			case 'maxlength'	: $this->maxlength = $value;
				break;
			case 'name'			: $this->name = $value;
				break;
			case 'rows'			: $this->rows = $value;
				break;
			case 'size'			: $this->size = $value;
				break;
			case 'tabindex'		: $this->tabindex = $value;
				break;
			case 'type'			: $this->type = $value;
				break;
			case 'value'		: $this->value = $value;
				break;
				
			default				: parent::setAttribute($attribute,$value);
		}//eof sqitch
	}//eof function
	
	//return table's attribute
	public function getAttribute($att='')
	{
		//if attribute not given, return all
		if($att=='')
		{				
			if(isset($this->cols))
				$value.=' cols="'.$this->cols.'"';
			
			if(isset($this->labelfor))
				$value.=' for="'.$this->labelfor.'"';
					
			if(isset($this->maxlength))
				$value.=' maxlength="'.$this->maxlength.'"';
						
			if(isset($this->name))
				$value.=' name="'.$this->name.'"';
						
			if(isset($this->rows))
				$value.=' rows="'.$this->rows.'"';
				
			if(isset($this->size))
				$value.=' size="'.$this->size.'"';
						
			if(isset($this->tabindex))
				$value.=' tabindex="'.$this->tabindex.'"';
						
			if(isset($this->type))
				$value.=' type="'.$this->type.'"';
						
			if(isset($this->value))
				$value.=' value="'.$this->value.'"';
								
			$value.=parent::getAttribute();
		}//eof if
		//else, return by attribute given
		else
		{
			//switch / select attribute type
			switch(strtolower($att))
			{	
				case 'cols'			: $value=$this->cols;
					break;
				case 'for'			: $value=$this->labelfor;
					break;
				case 'maxlength'	: $value=$this->maxlength;
					break;
				case 'name'			: $value=$this->name;
					break;
				case 'rows'			: $value=$this->rows;
					break;
				case 'size'			: $value=$this->size;
					break;
				case 'tabindex'		: $value=$this->tabindex;
					break;
				case 'type'			: $value=$this->type;
					break;
				case 'value'		: $value=$this->value;
					break;
				default				: $value=parent::getAttribute($att);
			}//eof switch
		}//eof else
		
		return $value;
	}//eof function
	
	//create and return the field in string
	public function getField()
	{
		//extra attribute
		if($this->checked)
			$extra.=' checked';
		if($this->disabled)
			$extra.=' disabled';
		if($this->readonly)
			$extra.=' readonly';
		if($this->multiple)
			$extra.=' multiple';
		
		//switch type
		switch(strtolower($this->type))
		{
			case 'text'		:
			case 'password'	:
			case 'hidden'	:
			case 'file'		:
			case 'radio'	:
			case 'checkbox'	:
			case 'button'	:
			case 'submit'	:
			case 'reset'	:
				//create input
				$result='<input '.$this->getAttribute().$extra.'>';
				
				//if have label, put label tag and value
				if($this->label)
					$result='<label>'.$result.$this->label.'</label>';
				break;
			
			//textarea
			case 'textarea'		:
				//create textarea
				$result='<textarea '.$this->getAttribute().$extra.'>';
				
				//strip type and value attribute from textarea
				$result=ereg_replace('value="'.$this->getAttribute('value').'"','',$result);
				$result=ereg_replace('type="'.$this->getAttribute('type').'"','',$result);
				
				//put value into textarea
				$result.=$this->getAttribute('value').'</textarea>';
				break;
			
			//label
			case 'label'	:
				//create label
				$result='<label '.$this->getAttribute().'>'.$this->label.'</label>';
				break;
			
			//select
			case 'select'	:
				//create select
				$result='<select '.$this->getAttribute().$extra.'>';
				
				//if option is array
				if(is_array($this->option))
				{
					$optionKeys=array_keys($this->option[0]);		//keys
					$optionCount=count($this->option);				//count
					
					//create option
					for($x=0;$x<$optionCount;$x++)
					{
						//open option tag
						$result.='<option value="'.$this->option[$x][$optionKeys[0]].'"';
						
						//if selected value is string
						if(is_string($this->selected))
						{
							//if option value is same with selected value
							if($this->option[$x][$optionKeys[0]]==$this->selected)
								$result.=' selected';
						}//eof if
						//else, if selected value is array
						else if(is_array($this->selected))
						{
							$selectedKeys=array_keys($this->selected);		//keys
							$selectedCount=count($this->selected);			//count
							
							//if option value is same with selected value
							for($y=0;$y<$selectedCount;$y++)
							{
								if($this->option[$x][$optionKeys[0]]==$this->selected[$selectedKeys[$x]])
								{
									$result.=' selected';
									break 1;
								}//eof if
							}//eof for
						}//eof else if
						
						//close option tag
						$result.='>'.$this->option[$x][$optionKeys[1]].'</option>';
					}//eof for
				}//eof if

				//close select tag
				$result.='</select>';
				break;
		}//eof switch
		
		return $result;
	}//eof function
	
	//display the field
	public function showField()
	{
		echo $this->getField();
	}//eof function
	
	//set label
	public function setLabel($label)
	{
		$this->label=$label;
	}//eof status
	
	//get label
	public function getLabel()
	{
		return $this->label;
	}//eof status
	
	//set option (select)
	public function setOption($array)
	{
		$this->option=$array;
	}//eof status
	
	//get option value (select)
	public function getOption()
	{
		return $this->option;
	}//eof status
	
	//set selected value (select/radio/checkbox)
	public function setSelected($value)
	{
		$this->selected=$value;
	}//eof status
	
	//get selected value (select/radio/checkbox)
	public function getSelected()
	{
		return $this->selected;
	}//eof status
	
	//set checked status
	public function setChecked($status)
	{
		$this->checked=$status;
	}//eof status
	
	//get checked status
	public function getChecked()
	{
		return $this->checked;
	}//eof status
	
	//set disabled status
	public function setDisabled($status)
	{
		$this->disabled=$status;
	}//eof status
	
	//get disabled status
	public function getDisabled()
	{
		return $this->disabled;
	}//eof status
	
	//set multiple status
	public function setMultiple($status)
	{
		$this->multiple=$status;
	}//eof status
	
	//get multiple status
	public function getMultiple()
	{
		return $this->multiple;
	}//eof status
	
	//set readonly status
	public function setReadonly($status)
	{
		$this->readonly=$status;
	}//eof status
	
	//get readonly status
	public function getReadonly()
	{
		return $this->readonly;
	}//eof status
	
}//eof class

?>