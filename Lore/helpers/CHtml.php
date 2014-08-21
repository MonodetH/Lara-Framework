<? 
	#
	#CHtml class file
	#Html helper
	#
	
	class CHtml{
		
		const ID_PREFIX='b';
		public static $count=0;
		
		#
		#	General
		
		public static function encode($text){
			return htmlspecialchars($text,ENT_QUOTES);
		}
		
		public static function decode($text){
			return htmlspecialchars_decode($text,ENT_QUOTES);
		}

		public static function cssFile($url){
			return '<link rel="stylesheet" type="text/css" href="'.self::encode($url).'" />';
		}

		public static function scriptFile($url){
			return '<script type="text/javascript" src="'.self::encode($url).'"></script>';
		}
		
		public static function cdata($text){
			return '<![CDATA[' . $text . ']]>';
		}
		
		public static function tag($tag,$htmlOptions=array(),$content=false,$closeTag=true){
			$html='<' . $tag . self::renderAttributes($htmlOptions);
			if($content===false)
				return $closeTag ? $html.' />' : $html.'>';
			else
				return $closeTag ? $html.'>'.$content.'</'.$tag.'>' : $html.'>'.$content;
		}
		
		public static function openTag($tag,$htmlOptions=array()){
			return '<' . $tag . self::renderAttributes($htmlOptions) . '>';
		}
	
		public static function closeTag($tag){
			return '</'.$tag.'>';
		}
		
		public static function link($text,$url='#',$htmlOptions=array()){
			if($url!=='')
				$htmlOptions['href']=$url;
			return self::tag('a',$htmlOptions,$text);
		}
		
		public static function mailto($text,$email='',$htmlOptions=array()){
			if($email==='')
				$email=$text;
			return self::link($text,'mailto:'.$email,$htmlOptions);
		}
		
		public static function image($src,$alt='',$htmlOptions=array()){
			$htmlOptions['src']=$src;
			$htmlOptions['alt']=$alt;
			return self::tag('img',$htmlOptions);
		}
		
		public static function htmlButton($label='button',$htmlOptions=array()){
			if(!isset($htmlOptions['name']))
				$htmlOptions['name']=self::ID_PREFIX.self::$count++;
			if(!isset($htmlOptions['type']))
				$htmlOptions['type']='button';
			return self::tag('button',$htmlOptions,$label);
		}
		#
		#Form
		
		public static function form($action='',$method='post',$htmlOptions=array()){
			return self::beginForm($action,$method,$htmlOptions);
		}

		public static function beginForm($action='',$method='post',$htmlOptions=array()){
			$htmlOptions['action']=$action;
			$htmlOptions['method']=$method;
			$form=self::tag('form',$htmlOptions,false,false);
			return $form;
		}

		public static function endForm(){
			return '</form>';
		}
		
		protected static function inputField($type,$name,$value,$htmlOptions){
			$htmlOptions['type']=$type;
			$htmlOptions['value']=$value;
			$htmlOptions['name']=$name;
			if(!isset($htmlOptions['id']))
				$htmlOptions['id']=self::getIdByName($name);
			else if($htmlOptions['id']===false)
				unset($htmlOptions['id']);
			return self::tag('input',$htmlOptions);
		}
		
		public static function button($label='button',$htmlOptions=array()){
			if(!isset($htmlOptions['name'])){
				if(!array_key_exists('name',$htmlOptions))
					$htmlOptions['name']=self::ID_PREFIX.self::$count++;
			}
			if(!isset($htmlOptions['type']))
				$htmlOptions['type']='button';
			if(!isset($htmlOptions['value']))
				$htmlOptions['value']=$label;
			return self::tag('input',$htmlOptions);
		}
		
		public static function submitButton($label='submit',$htmlOptions=array()){
			$htmlOptions['type']='submit';
			return self::button($label,$htmlOptions);
		}

		public static function resetButton($label='reset',$htmlOptions=array()){
			$htmlOptions['type']='reset';
			return self::button($label,$htmlOptions);
		}

		public static function imageButton($src,$htmlOptions=array()){
			$htmlOptions['src']=$src;
			$htmlOptions['type']='image';
			return self::button('submit',$htmlOptions);
		}

		public static function linkButton($label='submit',$htmlOptions=array()){
			if(!isset($htmlOptions['submit']))
				$htmlOptions['submit']=isset($htmlOptions['href']) ? $htmlOptions['href'] : '';
			return self::link($label,'#',$htmlOptions);
		}
		
		public static function label($label,$for,$htmlOptions=array()){
			if($for===false)
				unset($htmlOptions['for']);
			else
				$htmlOptions['for']=$for;
			return self::tag('label',$htmlOptions,$label);
		}
		
		public static function textField($name,$value='',$htmlOptions=array()){
			return self::inputField('text',$name,$value,$htmlOptions);
		}

		public static function hiddenField($name,$value='',$htmlOptions=array()){
			return self::inputField('hidden',$name,$value,$htmlOptions);
		}

		public static function passwordField($name,$value='',$htmlOptions=array()){
			return self::inputField('password',$name,$value,$htmlOptions);
		}
		
		public static function fileField($name,$value='',$htmlOptions=array()){
			return self::inputField('file',$name,$value,$htmlOptions);
		}
		
		public static function textArea($name,$value='',$htmlOptions=array()){
			$htmlOptions['name']=$name;
			if(!isset($htmlOptions['id']))
				$htmlOptions['id']=self::getIdByName($name);
			else if($htmlOptions['id']===false)
				unset($htmlOptions['id']);
			return self::tag('textarea',$htmlOptions,isset($htmlOptions['encode']) && !$htmlOptions['encode'] ? $value : self::encode($value));
		}
		
		#
		#Internal
		
		protected static function getIdByName($name){
			return str_replace(array('[]', '][', '[', ']', ' '), array('', '_', '_', '', '_'), $name);
		}
		
		protected static function renderAttributes($htmlOptions){
			static $specialAttributes=array(
				'checked'=>1,
				'declare'=>1,
				'defer'=>1,
				'disabled'=>1,
				'ismap'=>1,
				'multiple'=>1,
				'nohref'=>1,
				'noresize'=>1,
				'readonly'=>1,
				'selected'=>1,
				'required'=>1
			);
			if($htmlOptions===array())
				return '';
			$html='';
			if(isset($htmlOptions['encode'])){
				$raw=!$htmlOptions['encode'];
				unset($htmlOptions['encode']);
			}
			else
				$raw=false;
	
			foreach($htmlOptions as $name=>$value){
				if(isset($specialAttributes[$name])){
					if($value)
						$html .= ' ' . $name . '="' . $name . '"';
				}
				else if($value!==null)
					$html .= ' ' . $name . '="' . ($raw ? $value : self::encode($value)) . '"';
			}
			return $html;
		}
	}
	
?>