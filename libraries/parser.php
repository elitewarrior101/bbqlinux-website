<?

if (!defined('FRAMEWORK_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit('No direct script access allowed!'); 
}

class TemplateParser
{
	var $varcache = array();
	var $valuecache = array();
	var $tplvaluecache = array();
	var $tplcache = array();
	var $tplidcache = array();
	var $tplloopid = array();
	var $tpldestid = array();

	function TemplateParser($tpldir, $template)
	{
		$this->tplcache[] = '';
		$this->tplvaluecache[] = implode("",file("$tpldir".$template.'.tpl'));
		$this->tplidcache[] = 0;
		$this->tplloopid[] = '';
	}

	function assign($varname,$value,$destid)
	{
		if(is_array($value))
		{
			$var = $varname;
			$varname = array();
			$keys = array_keys($value);
			for($i=0;$i<count($keys);$i++)
			{
				$varname[] = '{$'.$var.'['.$keys[$i].']}';
			}
			unset($var,$keys);
		}
		else
		{
			$varname = '{$'.$varname.'}';
		}
		if($destid == 0)
		{
			if(in_array($varname,$this->varcache))
			{
				$id = array_search($varname,$this->varcache);
				$this->valuecache[$id] = $value;
			}
			else
			{
			$this->varcache[] = $varname;
			$this->valuecache[] = $value;
			}
			return;
		}
	
		if(!in_array($destid,$this->tplidcache))
		{
			echo 'ID: '.$destid.' ist nicht vorhanden';
		}
		$index = array_search($destid,$this->tplidcache);
		$this->tplvaluecache[$index] = str_replace($varname,$value,$this->tplvaluecache[$index]);
	}

	function assigntpl($tpldir,$tpl,$tplfile,$id,$loopid=NULL,$destloop=NULL)
	{       
		$tpl = '{$'.$tpl.'}';
	
		if(in_array($id,$this->tplidcache))
		{
			echo 'ID: '.$id.' bereits vergeben';
		}

		$this->tplcache[]    = $tpl;
		$this->tplvaluecache[]  = implode("",file("$tpldir".$tplfile.'.tpl'));
		$this->tplidcache[] = $id;
		$this->tplloopid[] = $loopid;
		
		if(is_integer($destloop))
		{
			if(!is_array($this->tpldestid[$destloop]))
				$this->tpldestid[$destloop] = array();
			
			if(!in_array($loopid,$this->tpldestid[$destloop]))
				$this->tpldestid[$destloop][] = $loopid;
		}
	}

	function clear()
	{
	  $this->tplcache = NULL;
	  $this->tplvaluecache = NULL;
	  $this->tplidcache = NULL;
	  $this->tplloopid = NULL;
	  $this->tpldestid = NULL;
	}  

	function array_search_all($needle,$haystack)
	{
		return array_keys(array_filter($haystack, create_function('$s','return $s
== \''.addslashes($needle).'\';')));
	}

	function parse()
	{
		$template = $this->tplvaluecache[0];
		$jump = array();
		$loop = array();
		for($i=0,$z=0;$i<count($this->tplcache);$i++)
		{
			if(is_integer($this->tplloopid[$i]))
			{
				if(!in_array($this->array_search_all($this->tplloopid[$i],$this->tplloopid),$loop))
				{
					$loop[$z] = $this->array_search_all($this->tplloopid[$i],$this->tplloopid);
					$z++;
				}
			}

		}

		for($i=1;$i<count($this->tplcache);$i++)
		{	
			if(!in_array($i,$jump))
			{
				if(!is_integer($this->tplloopid[$i]))
				{
					$template = str_replace($this->tplcache[$i],$this->tplvaluecache[$i],$template);
				}
				else
				{
					$l = 0;
					foreach($loop[$this->tplloopid[$i]] as $id)
					{
						$temp .= $this->tplvaluecache[$id];
						
						if(is_array($this->tpldestid[$this->tplloopid[$i]]) 
						&& is_integer($this->tpldestid[$this->tplloopid[$i]][$l]))
						{
							foreach($loop[$this->tpldestid[$this->tplloopid[$i]][$l]] as $subid)
							{
								$subtemp .= $this->tplvaluecache[$subid];
							}
							$temp= str_replace($this->tplcache[$subid],$subtemp,$temp);
							$jump = array_merge($jump,$loop[$this->tpldestid[$this->tplloopid[$i]][$l]]);
							$l++;
							unset($subtemp);
						}
					}
					$template = str_replace($this->tplcache[$i],$temp,$template);
					$jump = array_merge($jump,$loop[$this->tplloopid[$i]]);
					unset($temp);
					unset($l);
				}
			}
		}
	
		for($i=0;$i<count($this->varcache);$i++)
		{
			$template = str_replace($this->varcache[$i],$this->valuecache[$i],$template);
		}
		$pattern='%{([$])+([^}]+)}%e';
		$replacement="";
	
		$template = preg_replace($pattern,$replacement,$template);
		return $template;
	}

	function out()
	{
		return $this->parse();
	}
}

$TPLid=0;
$TPLloop=0;
?>
