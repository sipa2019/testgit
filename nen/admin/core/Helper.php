<?php
/**
 * Checks if a folder exist and return canonicalized absolute pathname (sort version)
 * @param string $folder the path being checked.
 * @return mixed returns the canonicalized absolute pathname on success otherwise FALSE is returned
 */
function folder_exist($folder)
{
    // Get canonicalized absolute pathname
    $path = realpath($folder);

    // If it exist, check if it's a directory
    return ($path !== false AND is_dir($path)) ? true : false;
};

function filesdir ( $folder, $prefiks, $id, $subdir ) {
					$mas	=	array();
					$dir    =	'../'.$folder.'/'.$prefiks.'/'.$id.'/'.$subdir;
					$dirr    =	'/'.$folder.'/'.$prefiks.'/'.$id.'/'.$subdir;
					$stack = folder_exist($dir);
					if($stack){
						$files	=	scandir($dir, 1);
						foreach ($files as $key => $value) {
							if( true === is_file($dir.'/'.$files[$key]) ){
								$mas[]=$dirr.'/'.$files[$key];
							}
						}
					}
return $mas;
}		

function previewfolder($folder,$prefiks, $id, $subdir ){
for ($x=0; $x < count($subdir);$x++){
									$mas='mas'.$x;
									$$mas = filesdir( $folder, $prefiks, $id, $subdir[$x] );
								}
	return $mas=array_merge((array)$mas0, (array)$mas1, (array)$mas2) ;
}
/*
// получить порядковый номер из счетчика
*/
function newCount($file ){
$file=$file.'.txt';
$count=(int)file_get_contents ("../../data/number/".$file);
$fak_rek=$count;
$count=$count+1;
$countf = fopen ("../../data/number/".$file, "r+");
flock($countf,2);
fputs ( $countf, $count);
fclose ($countf);	
	return $count;
}

/*
// сформировать новый номер обращений/заказнарядов из порядкового номера
*/
function newNumber($doc, $count, $prefix  ){
						$date				=	date('Y-m-d:H-i');
						$togads				=	date("Y"); 
						$tomes				=	date("m");
	$number=$doc.$count."/".$tomes."/".substr($togads,-2).$prefix;
return $number;	
}

/*
//Преобразуем объект пришедший от клиента в ассоциативный массив, для записи в Table по нужным полям записи
*/
function GetNeedFieldsTable($Objdata, $fieldsTable){

			$dataFill	=	array();
			
			foreach ($fieldsTable as $key => $value){
				if ($key != 'created_at'){
					isset ( $Objdata[$key] )? $dataFill[$key]=$Objdata[$key]: $dataFill[$key]='';
				}
			}
			
return $dataFill;			
}

/*
// дата вида число/мес/год апреобразуется в дату вида год-мес-число
*/

function date_podmysql($vhod_date)
{
												$mes=substr($vhod_date,3,2);
												$cis=substr($vhod_date,0,2);
												$god=substr($vhod_date,6,4);
												$vihod_date=$god."-".$mes."-".$cis;
return $vihod_date;
}

/*
// дата вида год/мес/число апреобразуется в дату вида число-мес-год
*/

function date_frommysql($vhod_date)
{
												$mes=substr($vhod_date,5,2);
												$cis=substr($vhod_date,8,2);
												$god=substr($vhod_date,0,4);
												
												$vihod_date=$cis."-".$mes."-".$god;
return $vihod_date;
}


/*
//создает рекурсивно дирректорию для записи, если ее нет
//$path	= 	'../upload/auto/100';
*/
function createPath($path) {
    if (is_dir($path)) return true;
    $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
    $return = createPath($prev_path);
    return ($return && is_writable($prev_path)) ? mkdir($path) : false;
}

/*
//Перемещение загруженного файла из Дирректории $to/$from(0) в дирректорию $to/$id
*/

function RemoveFileFromDir($foto, $id, $from ,$to){
						$pieces = explode(",", $foto);
						$resultCount = count($pieces);
								for($i=0; $i<$resultCount; $i++){
								$part = explode("/", $pieces[$i]);	
								$reversed = array_reverse($part);
								$NameFile=$reversed[0];
								$CategorijaFile=$reversed[1];
								$uploaddir		= 	'../upload/'.$to.'/'.$id.'/'.$CategorijaFile.'/';
								$dirMoveFile	= 	'../upload/'.$to.'/'.$from.'/'.$CategorijaFile.'/';
								$resultat=createPath($uploaddir);
								$resultat2=createPath($dirMoveFile);
									if (!copy($dirMoveFile.$NameFile,$uploaddir.$NameFile)) {
										$result='false';
									}else{
										unlink($dirMoveFile.$NameFile);
										$result='true';
									}
								}

return $result;
}


function render($template, $params = array())
{
  return function_get_output('display', $template, $params);
}

function function_get_output($fn)
{
  $args = func_get_args();unset($args[0]);
  ob_start();
  call_user_func_array($fn, $args);
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}

function display($template, $params = array())
{
  extract($params);
  include $template;
}

function FullTree($records, $FromWhere){
	$countRow = count($records);
	if('Order' == $FromWhere){
		$dop='(*)';
		$num='numersf';
	}else{
		$dop='';
		$num='numer';
	}
						$data00		=	array();
						$data01		=	array();
						$data02		=	array();
						$data03		=	array();
						$data04		=	array();
						$datahiden	=	array();
						$datasaven	=	array();
						$datanewn	=	array();
						$dataApdTame=	array();
						$dataApdRek	=	array();
							    for ($z=0; $z < $countRow;$z++)	{
										
									if ('00' 	== $records[$z]->status){$data00[]=$records[$z]->numersf.$dop;}
									if ('01' 	== $records[$z]->status){$data01[]=$records[$z]->numersf.$dop;}
									if ('02' 	== $records[$z]->status){$data02[]=$records[$z]->numersf.$dop;}
									if ('03' 	== $records[$z]->status){$data03[]=$records[$z]->numersf.$dop;}
									if ('04' 	== $records[$z]->status){$data04[]=$records[$z]->numersf.$dop;}
									if('Order' <> $FromWhere){
									if ('hiden' == $records[$z]->status){$datahiden[]=$records[$z]->numer.$dop;}
									if ('saven' == $records[$z]->status){$datasaven[]=$records[$z]->numer.$dop;}
									if ('newn' 	== $records[$z]->status){$datanewn[]=$records[$z]->numer.$dop;}
									//заполняем только из Обращений, в Заказх поля 	lietasnumurs нет
										//if('Order' <> $FromWhere){
											if ('' !==  $records[$z]->lietasnumurs
											&& '00' ==  $records[$z]->status )
											{$dataApdTame[]=$records[$z]->numer;}
										
											if ('' 	   	!==	$records[$z]->lietasnumurs && NULL !==  $records[$z]->lietasnumurs  
											&& '00'     !==	$records[$z]->status 
											&& 'hiden'	!== $records[$z]->status 
											&& 'saven'	!== $records[$z]->status 
											&& 'newn'	!== $records[$z]->status)
											{$dataApdRek[]=$records[$z]->numersf;}
										}
							}
$TreeData	=	array();
$TreeData[0]=$data00;
$TreeData[1]=$data01;
$TreeData[2]=$data02;
$TreeData[3]=$data03;
$TreeData[4]=$data04;
$TreeData[5]=$datahiden;
$TreeData[6]=$datasaven;
//$TreeData[7]=$datanewn;
$TreeData[7]=$dataApdTame;
$TreeData[8]=$dataApdRek;
return 	$TreeData;						
}
?>