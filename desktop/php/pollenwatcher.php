<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('pollenwatcher');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType("pollenwatcher");
?>



<div class="row row-overflow">

  <div class="col-lg-2 col-sm-3 col-sm-4">
    <div class="bs-sidebar">
      <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
        <?php
        foreach ($eqLogics as $eqLogic) {
          echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
        }
        ?>
      </ul>
    </div>
  </div>

  
  

   <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
    <legend>{{Surveillance Allergo Pollinique}}</legend>
  <legend><i class="fa fa-cog"></i>{{Gestion}}</legend>
  <div class="eqLogicThumbnailContainer">
	  
		<div class="cursor eqLogicAction" data-action="add" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
			<i class="fa fa-plus-circle" style="font-size : 6em;color:#DF2B2F;"></i>
			<br>
			<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;;color:#DF2B2F">{{Ajouter}}</span>
		</div>
	
		
		<div class="cursor eqLogicAction" data-action="gotoPluginConf" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
			<i class="fa fa-wrench" style="font-size : 6em;color:#767676;"></i><br>
			<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676">{{Configuration}}</span>
		</div>
  </div>
  <legend><i class="fa fa-lightbulb-o"></i> {{Mes Bulletins}}</legend>
<div class="eqLogicThumbnailContainer">




    <?php
foreach ($eqLogics as $eqLogic) {
	$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
	echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
	echo '<img src="plugins/pollenwatcher/plugin_info/pollenwatcher_notitle_icon.png" height="105" width="95" />';
	echo "<br>";
	echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
	echo '</div>';
}
?>
</div>
</div>

<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
	<a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
  <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
  <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
    <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
    <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
  </ul>
  <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
    <div role="tabpanel" class="tab-pane active" id="eqlogictab">
      <br/>
    <form class="form-horizontal">
        <fieldset>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{Nom de l'équipement template}}</label>
                <div class="col-sm-3">
                    <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                    <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement template}}"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" >{{Objet parent}}</label>
                <div class="col-sm-3">
                    <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
                        <option value="">{{Aucun}}</option>
                        <?php
							foreach (object::all() as $object) {
								echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
							}
						?>
                   </select>
               </div>
           </div>
	   <div class="form-group">
                <label class="col-sm-3 control-label">{{Catégorie}}</label>
                <div class="col-sm-9">
                 <?php
                    foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                    echo '<label class="checkbox-inline">';
                    echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                    echo '</label>';
                    }
                  ?>
               </div>
           </div>
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
				<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">{{Region}}</label>
			<div class="col-sm-3">
				<select id="sel_object" class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="region_id">					
					<option value="1">Ain</option>
					<option value="2">Aisne</option>
					<option value="3">Allier</option>
					<option value="4">Alpes-de-Haute-Provence</option>
					<option value="5">Hautes-Alpes</option>
					<option value="6">Alpes-Maritimes</option>
					<option value="7">Ardèche</option>
					<option value="8">Ardennes</option>
					<option value="9">Ariège</option>
					<option value="10">Aube</option>
					<option value="11">Aude</option>
					<option value="12">Aveyron</option>
					<option value="13">Bouches-du-Rhône</option>
					<option value="14">Calvados</option>
					<option value="15">Cantal</option>
					<option value="16">Charente</option>
					<option value="17">Charente-Maritime</option>
					<option value="18">Cher</option>
					<option value="19">Corrèze</option>
					<option value="21">Côte-d'or</option>
					<option value="22">Côtes-d'armor</option>
					<option value="23">Creuse</option>
					<option value="24">Dordogne</option>
					<option value="25">Doubs</option>
					<option value="26">Drôme</option>
					<option value="27">Eure</option>
					<option value="28">Eure-et-Loir</option>
					<option value="29">Finistère</option>
					<option value="20">Corse</option>
					<option value="30">Gard</option>
					<option value="31">Haute-Garonne</option>
					<option value="32">Gers</option>
					<option value="33">Gironde</option>
					<option value="34">Hérault</option>
					<option value="35">Ille-et-Vilaine</option>
					<option value="36">Indre</option>
					<option value="37">Indre-et-Loire</option>
					<option value="38">Isère</option>
					<option value="39">Jura</option>
					<option value="40">Landes</option>
					<option value="41">Loir-et-Cher</option>
					<option value="42">Loire</option>
					<option value="43">Haute-Loire</option>
					<option value="44">Loire-Atlantique</option>
					<option value="45">Loiret</option>
					<option value="46">Lot</option>
					<option value="47">Lot-et-Garonne</option>
					<option value="48">Lozère</option>
					<option value="49">Maine-et-Loire</option>
					<option value="50">Manche</option>
					<option value="51">Marne</option>
					<option value="52">Haute-Marne</option>
					<option value="53">Mayenne</option>
					<option value="54">Meurthe-et-Moselle</option>
					<option value="55">Meuse</option>
					<option value="56">Morbihan</option>
					<option value="57">Moselle</option>
					<option value="58">Nièvre</option>
					<option value="59">Nord</option>
					<option value="60">Oise</option>
					<option value="61">Orne</option>
					<option value="62">Pas-de-Calais</option>
					<option value="63">Puy-de-Dôme</option>
					<option value="64">Pyrénées-Atlantiques</option>
					<option value="65">Hautes-Pyrénées</option>
					<option value="66">Pyrénées-Orientales</option>
					<option value="67">Bas-Rhin</option>
					<option value="68">Haut-Rhin</option>
					<option value="69">Rhône</option>
					<option value="70">Haute-Saône</option>
					<option value="71">Saône-et-Loire</option>
					<option value="72">Sarthe</option>
					<option value="73">Savoie</option>
					<option value="74">Haute-Savoie</option>
					<option value="75">Paris</option>
					<option value="76">Seine-Maritime</option>
					<option value="77">Seine-et-Marne</option>
					<option value="78">Yvelines</option>
					<option value="79">Deux-Sèvres</option>
					<option value="80">Somme</option>
					<option value="81">Tarn</option>
					<option value="82">Tarn-et-Garonne</option>
					<option value="83">Var</option>
					<option value="84">Vaucluse</option>
					<option value="85">Vendée</option>
					<option value="86">Vienne</option>
					<option value="87">Haute-Vienne</option>
					<option value="88">Vosges</option>
					<option value="89">Yonne</option>
					<option value="90">Territoire de Belfort</option>
					<option value="91">Essonne</option>
					<option value="92">Hauts-de-Seine</option>
					<option value="93">Seine-Saint-Denis</option>
					<option value="94">Val-de-Marne</option>
					<option value="95">Val-d'oise</option>
                </select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label">{{Style affichage valeur globale}}</label>
			<div class="col-sm-3">
				<select id="sel_object" class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="global_style">					
					<option value="global_style_circle_thin">Cercle fin & texte blanc</option>
					<option value="global_style_circle_thin_color">Cercle fin & texte en couleur</option>
					<option value="global_style_circle_thin_color_white">Cercle fin blanc & texte blanc</option>
					<option value="global_style_circle_o">Cercle épais & texte blanc</option>
					<option value="global_style_circle_o_color">Cercle épais & texte en couleur</option>
					<option value="global_style_circle_o_color_white">Cercle épais blanc & texte blanc</option>
					<option value="global_style_circle_plain">Rond & texte blanc</option>
					<option value="global_style_circle_plain_only">Rond sans texte</option>
					<option value="none">sans</option>
				</select>
			</div>
		</div>
</fieldset>
</form>
</div>
      <div role="tabpanel" class="tab-pane" id="commandtab">
<a class="btn btn-success btn-sm cmdAction pull-right" data-action="add" style="margin-top:5px;"><i class="fa fa-plus-circle"></i> {{Commandes}}</a><br/><br/>
<table id="table_cmd" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>{{Nom}}</th>
			<th>{{Type}}</th>
			<th>{{Action}}</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</div>
</div>

</div>
</div>

<?php include_file('desktop', 'pollenwatcher', 'js', 'pollenwatcher');
?>
<?php include_file('core', 'plugin.template', 'js'); ?>