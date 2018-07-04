<?php 
class pdf_upload 
{
	var $_prefix = '';
	var $suffix_ = '';
	var $file_size_type = 'MB';
	var $file_size = '1';

	var $upload_dir = NULL;
	var $error = NULL;
	var $file_names = array();

	var $document_size_type = 'MB';
	var $document_size = '1';
	var $document_names = NULL;
	
	var $uploaded_files = array();
	var $uploaded = false;
	var $new_file_name = NULL;
	var $info = NULL;

	function document_names($names) 
	{
		$this->document_names = $names;
  }
	
	function upload_dir($upload_dir) 
	{
		if (!is_dir($upload_dir)) 
		{
			$this->error .= $upload_dir." "._p("UploadFileText1");
		}
		
		if (is_dir($upload_dir) && !is_writable($upload_dir)) 
		{
			$this->error .= $upload_dir." "._p("UploadFileText2");
		}
				
		$this->upload_dir = $upload_dir;
	}

	function files($file_names) 
	{
		if ($file_names['name']) 
		{
			$this->files['tmp_name'][] = $file_names['tmp_name'];
			$this->files['name'][] = $file_names['name'];
			$this->files['type'][] = $file_names['type'];
			$this->files['size'][] = $file_names['size'];
		}
	}


	function is_file_extension($mime_types) 
	{
		//for ($i = 0; $i <= count($this->files['tmp_name']); $i++) 
		//{
			if (!in_array($this->file_extension($this->files['name'][0]), $mime_types))
			{
				$this->error .= $this->files['name'][0]." "._p("UploadFileText3");
			}
		//}
	}	

	function file_extension($file_name) 
	{
		$file_name_extension = strtolower(substr(strrchr($file_name, '.'), 1));
		return $file_name_extension;
	}

	function size_find() 
	{
		if (!$this->error) 
		{
			$mime_types_document = array('application/pdf');

			//for ($i = 0; $i < count($this->files['tmp_name']); $i++) 
			//{
				if (in_array($this->files['type'][0], $mime_types_document)) 
				{
					$file_size = $this->all2kbytes($this->file_size, $this->file_size_type);
					$this->size_compare($this->files['size'][0], $file_size, $this->files['name'][0]);
				}else 
				{
					$document_size = $this->all2kbytes($this->document_size, $this->document_size_type);
					$this->size_compare($this->files['size'][0], $document_size, $this->files['name'][0]);
				}
			//}
		}
	}
	
	function all2kbytes($value, $file_size_type) 
	{
		switch ($file_size_type) 
		{
			case 'B':
				$values = round(($value), 2);
				break;
			case 'KB':
				$values = round(($value * 1024), 2);
				break;
			case 'MB':
				$values = round(($value * 1024 * 1024), 2);
				break;
			case 'GB':
				$values = round(($value * 1024 * 1024 * 1024), 2);
				break;
		}

		return $values;		
	}

	function size_compare($size, $file_size, $file_name) 
	{
		if ($size > $file_size) 
		{
			$this->error .= $file_name." "._p("UploadFileText4")." ".$file_size." "._p("UploadFileText5");	
		}
	}

	function upload() 
	{
		if (!$this->error) 
		{
			//for ($i = 0; $i < count($this->files['tmp_name']); $i++) 
			//{
				$this->new_file_name = $this->file_name_control($this->files['name'][0]);
				
				if(!move_uploaded_file($this->files['tmp_name'][0], $this->upload_dir.'/'.$this->new_file_name))
				{
					return $this->uploaded = false;
				}else
				{
					$this->uploaded_files[] = $this->new_file_name;
					$this->info .= $this->files['name'][0]." "._p("UploadFileText6")." ".$this->new_file_name." "._p("UploadFileText7");
					return $this->uploaded = true;
				}
			//}
			
		}
	}

	function file_name_control($file_name) 
	{
		$file_name = $this->bad_character_rewrite($file_name);
		
		$unique_name = $file_name;
		$unique_name = $this->prefixsuffix($unique_name, $this->_prefix, $this->suffix_); 
		
		return $unique_name;
	}

	function bad_character_rewrite($text) 
	{
		$first = array("\\", "/", ":", ";", "~", "|", "(", ")", "\"", "#", "*", "$", "@", "%", "[", "]", "{", "}", "<", ">", "`", "'", ",", " ", "&#287;", "&#286;", "ü", "Ü", "&#351;", "&#350;", "&#305;", "&#304;", "ö", "Ö", "ç", "Ç");
		$last = array("_", "_", "_", "_", "_", "_", "", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "", "_", "_", "g", "G", "u", "U", "s", "S", "i", "I", "o", "O", "c", "C");
		$text_rewrite = str_replace($first, $last, $text);
		return $text_rewrite;
	}

	function prefixsuffix($file_name, $prefix, $suffix) 
	{
		$file_name_info = pathinfo($file_name);
		$file_name = $file_name_info['filename'];
		$ext = '.'.$file_name_info['extension'];
		return $result = $prefix.$this->document_names."_".rand(0001, 9999).$suffix.$ext;
	}

	function first_values($_prefix, $suffix_, $file_size_type, $file_size) 
	{
		$this->suffix_			=	$suffix_;
		$this->_prefix			=	$_prefix;
		$this->file_size_type	=	$file_size_type;
		$this->file_size 		=	$file_size;
	}

	function uploader_set($file_name, $name, $upload_dir, $mime_types) 
	{	
		$this->upload_dir($upload_dir);
		$this->files($file_name);
		$this->document_names($name);
		$this->is_file_extension($mime_types);
		$this->size_find();
		$this->upload();
	}

}
?>
