<?php
/**
 * @package HelpHaiti
 * @author Cesar David Bernal Moreno
 * @version 1.0
 */
/*This plugin is under the GNU license. You can use it for free and can modify it but always you have to maintain the links to my website.
Este plugin se encuentra bajo licencia GNU. Puedes usarlo gratis y modificarlo, pero siempre tienes que mantener los links a mi sitio web.
*/
/*
Plugin Name: HelpHaiti
Plugin URI: http://www.divagando.com.es/
Description: You can light a candle in your blog in remember for the Haiti hearthquake victims. Puedes encender una vela en tu blog en recuerdo de las victimas del terremoto de Haiti
Author: Cesar David Bernal Moreno
Version: 1.0
Author URI: http://www.divagando.com.es/
*/

function helphaiti() {
$haiti_s=$_SERVER['HTTP_HOST'];
$haiti_idioma=$_SERVER['HTTP_ACCEPT_LANGUAGE'];
if ($haiti_idioma == "es"){
$haiti_vic= "Página web solidaria con las víctimas de Haiti";}
else{
$haiti_vic= "Solidary website with Haiti victims";}
echo "<a href='http://www.divagando.com.es'><img id='helphaiti' title='".$haiti_vic."' src='http://www.divagando.com.es/helphaiti/helphaitidb.php?i=".$haiti_idioma."&s=".$haiti_s."/'></a>";
}

add_action('wp_footer', 'helphaiti');

function haiticss() {
global $wpdb; 
   $table_name = $wpdb->prefix . "helphaiti";
   $haiti_recogepos= $wpdb->get_var("SELECT pos FROM $table_name WHERE id= '1';");

	if ($haiti_recogepos=="iar"){
	$haiti_float="left";
	$haiti_supinf="top";
	}
	elseif ($haiti_recogepos=="dar"){
	$haiti_float="right";
	$haiti_supinf="top";
	}
	elseif ($haiti_recogepos=="iab"){
	$haiti_float="left";
	$haiti_supinf="bottom";
	}
	else {
	$haiti_float="right";
	$haiti_supinf="bottom";
	}
	echo "
	<style type='text/css'>
	#helphaiti {
		float:".$haiti_float.";
		position: fixed;
		".$haiti_float.": 0;
		".$haiti_supinf.": 0;
		margin: 0;
		padding: 0;
	}
	</style>
	";
}

add_action('wp_footer', 'haiticss');


function sethaiti() {
global $wpdb;
$table_name = $wpdb->prefix . "helphaiti";
   if(isset($_POST['haitipos'])){
		 $haitipos = $_POST['haitipos'];
         $haiti_sql = "UPDATE $table_name SET pos='$haitipos' WHERE id='1'";
         $wpdb->query($haiti_sql);
		 }

$haiti_idioma=$_SERVER['HTTP_ACCEPT_LANGUAGE'];
if ($haiti_idioma == "es"){
$haiti_choose="Elija la posición de la vela en pantalla";
$haiti_iar= "Superior izquierda";
$haiti_dar= "Superior derecha";
$haiti_iab= "Inferior izquierda";
$haiti_dab= "Inferior derecha";
$haiti_boton= "Aplicar nueva posición";
}
else{
$haiti_choose="Choose screen position for the candle";
$haiti_iar= "Top left";
$haiti_dar= "Top right";
$haiti_iab= "Bottom left";
$haiti_dab= "Bottom right";
$haiti_boton= "Apply new position";
}

    $haiti_recogepos= $wpdb->get_var("SELECT pos FROM $table_name WHERE id= '1';");
   	if ($haiti_recogepos== "iar"){
	$haiti1= "checked";}
	elseif ($haiti_recogepos== "dar"){
	$haiti2= "checked";}
	elseif ($haiti_recogepos== "iab"){
	$haiti3= "checked";}
	else {
	$haiti4= "checked";}
	

?>
<div class="wrap"> 
   <form method="post" action="">
      <fieldset>
         <h2><?php echo $haiti_choose; ?></h2>
		 <br>
        <input type="Radio" name="haitipos" value="iar" <?php echo $haiti1 ?>><?php echo $haiti_iar ?><br>
		<input type="Radio" name="haitipos" value="dar" <?php echo $haiti2 ?>><?php echo $haiti_dar ?><br>
		<input type="Radio" name="haitipos" value="iab" <?php echo $haiti3 ?>><?php echo $haiti_iab ?><br>
		<input type="Radio" name="haitipos" value="dab" <?php echo $haiti4 ?>><?php echo $haiti_dab ?><br><br>
        <input type='submit' value='<?php echo $haiti_boton ?>'>
      </fieldset>
   </form>
</div>
<?php
}

function haitimenu (){
add_menu_page('Configuracion', 'HelpHaiti Plugin', 'administrator', '__FILE__', 'sethaiti');
}
add_action('admin_menu', 'haitimenu');

function haiti_instala(){
   global $wpdb;
   $table_name= $wpdb->prefix . "helphaiti";
   $haiti_sql = " CREATE TABLE $table_name(
      id mediumint( 9 ) NOT NULL AUTO_INCREMENT ,
      pos tinytext NOT NULL ,
      PRIMARY KEY ( `id` )   
   ) ;";
   $wpdb->query($haiti_sql);
   $haiti_sql = "INSERT INTO $table_name (pos) VALUES ('dab');";
   $wpdb->query($haiti_sql);
}   

function haiti_desinstala(){
   global $wpdb; 
   $tabla_nombre = $wpdb->prefix . "helphaiti";
   $sql = "DROP TABLE $tabla_nombre";
   $wpdb->query($sql);
}

register_activation_hook( __FILE__, 'haiti_instala' );
register_deactivation_hook( __FILE__, 'haiti_desinstala' );
?>