<?php
require_once('./config.php');
 require_once( ROOT_PATH . '/includes/functions.php');
 require_once( ROOT_PATH . '/includes/head_section.php');

 $result = get_JTEI_Issues();
 $year_arr = getYearJTEI();
 $selected_year=[];

 if(isset($_POST['filtroAvanzato'])){
  $result = filtroAvanzatoJTEI($_POST);
  if(!empty($_POST['autore'])){
    $autore = $_POST['autore'];
  }else{
    $autore = '';
  }
  if(!empty($_POST['titolo'])){
    $titolo = $_POST['titolo'];
  }else{
    $titolo = '';
  }
  foreach($result as $k => $val){
    if(!empty($val['art_year'])){
      $selected_year_raw[] = $val['art_year'];
      $selected_year = array_unique($selected_year_raw);
    }
  }
}

if(isset($_POST['reset'])){
  $_POST = [];
  $result = get_JTEI_Issues();
}
?>
<script>
    $(document).ready(function() {
      <?php  require_once( ROOT_PATH . '/includes/datatable_config.php');?>

      $('.selectpicker').selectpicker();
      $('#DA_A').hide();

      $('#annoDA').prop("disabled", true);
      $(".selectpicker[data-id='annoDA']").addClass("disabled"); 

      $('#annoA').prop("disabled", true);
      $(".selectpicker[data-id='annoDA']").addClass("disabled"); 

      $('#checkRange').click(function() {
        if($(this).prop("checked") == true) {      
          $('#DA_A').show();
          $('#annoDIV').hide();
          $('#anno').prop("disabled", true);
          $(".selectpicker[data-id='anno']").addClass("disabled");    
          
          $('#annoDA').prop("disabled", false);
          $(".selectpicker[data-id='annoDA']").removeClass("disabled"); 

          $('#annoA').prop("disabled", false);
          $(".selectpicker[data-id='annoA']").removeClass("disabled"); 
        }
        else if($(this).prop("checked") == false) {
          $('#DA_A').hide();
          $('#annoDIV').show()
          $('#anno').prop("disabled", false);
          $(".selectpicker[data-id='anno']").removeClass("disabled");

          $('#annoDA').prop("disabled", true);
          $(".selectpicker[data-id='annoDA']").addClass("disabled"); 

          $('#annoA').prop("disabled", true);
          $(".selectpicker[data-id='annoDA']").addClass("disabled");

        }
      });
    });

</script>
<style>
  .focus:hover{
    background-color:lightyellow;
    text-decoration: none;
  }
  .focus a:hover{
   text-decoration: none !important;
  }
  body{
    background-image: url('./bg.jpg');
  }
  
</style>
<body>

<!--navbar-->
<?php require_once( ROOT_PATH . '/includes/navbar.php') ?>

<main role="main">
<div class="container-fluid" style="margin-top:10%;">
      <div class="row">
              <div class="col-md-4 offset-1 " style="text-align:justify;margin-right:1%;" >
                  <h3><a href="https://journals.openedition.org/jtei/">JTEI</a></h3>
                      <p>Il Journal of the Text Encoding Initiative ?? la gazzetta ufficiale del Text Encoding Initiative Consortium. Pubblica gli atti della conferenza annuale TEI e dell'assemblea dei membri e questioni tematiche speciali: rapporti all'avanguardia 
                        sull'editing testuale elettronico, tendenze attuali nella codifica TEI e nuovi casi d'uso per TEI.
                        Fornisce inoltre un forum per articoli sulla discussione dell'interfaccia tra il TEI e altre comunit?? e, pi?? in generale, sul ruolo degli standard tecnologici nelle digital humanities, tra cui l'editing accademico digitale, l'analisi linguistica, la creazione di corpora e aree pi?? recenti come 
                        la digitalizzazione di massa, la ricerca sul web semantico e l'editing all'interno di mondi virtuali.

                    </p>
              </div>  

              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-10 offset-2" style="padding:20px;border:2px solid #007bff;border-radius:30px;background-color:white;">
                    <h4>Filtro avanzato</h4>
                        <form action="jtei.php" method="POST">
                        <div class="form-row"  style="margin-top:1%;">
                            <div class="col">
                              <label>Autore</label>
                              <input type="text" name="autore" id="autore" class="form-control" autocomplete="off" placeholder="Inserisci nome o cognome" value="<?php if(isset($_POST['filtroAvanzato'])){print $autore;} ?>">
                            </div>
                          </div>
                          <div class="form-row"  style="margin-top:1%;">
                            <div class="col">
                              <label>Titolo</label>
                              <input type="text" name="titolo" id="titolo" class="form-control" autocomplete="off" placeholder="Inserisci Keyword" value="<?php if(isset($_POST['filtroAvanzato'])){print $titolo;} ?>">
                            </div>
                          </div>      
                          <div class="form-row"  style="margin-top:1%;" id="annoDIV">
                            <div class="col-md-4">
                              <label>Anno</label>              
                                <select  name="anno[]" id="anno" class="form-control selectpicker" multiple>                                   
                                  <?php foreach($year_arr as $k => $val){?>
                                    <option value="<?= $val['art_year'] ?>"
                                    <?php 
                                    if(!empty($selected_year)){
                                    if(isset($_POST['filtroAvanzato'])){
                                      if( in_array($val['art_year'],$selected_year)){
                                        print 'selected';
                                      }
                                    }}
                                  ?>
                                    ><?= $val['art_year'] ?></option>
                                  <?php }?>                              
                                </select>     
                             
                            </div>
                          </div>
                          <div class="form-row"  style="margin-top:1%;" id="DA_A">
                            <div class="col">
                              <label>Da:</label>
                              <select  name="annoDA" id="annoDA" class="form-control selectpicker">  
                                <option value="">   </option>                      
                                  <?php foreach(array_reverse($year_arr) as $k => $val){?>
                                    <option value="<?= $val['art_year'] ?>"
                                    <?php 
                                    if(isset($_POST['filtroAvanzato'])){
                                      if(!empty($_POST['annoDA'])){
                                      if($val['art_year'] == $_POST['annoDA']){
                                        print 'selected';
                                      }
                                    }}
                                    ?>
                                    ><?= $val['art_year'] ?></option>
                                  <?php }?>                              
                                </select>  
                            </div>
                            <div class="col">
                              <label>A:</label>
                              <select  name="annoA" id="annoA" class="form-control selectpicker">  
                                <option value=""></option>                           
                                  <?php foreach($year_arr as $k => $val){?>
                                    <option value="<?= $val['art_year'] ?>"
                                    <?php 
                                    if(isset($_POST['filtroAvanzato'])){
                                      if(!empty($_POST['annoA'])){
                                      if($val['art_year'] == $_POST['annoA']){
                                        print 'selected';
                                      }
                                    }}
                                    ?>><?= $val['art_year'] ?></option>
                                  <?php }?>                              
                                </select>                             
                            </div>
                          </div>
                            
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="checkRange">
                              <label class="form-check-label" for="checkRange">Abilita ricerca per intervallo temporale </label>
                            </div>
                    
                            <button type="submit" name="filtroAvanzato" id="filtroAvanzato" class="btn btn-primary" style="margin-left:2%;margin-top:3%;float:right;width:30%;">Filtra</button>
                            <button type="submit"  name="reset" id="reset" class="btn btn-secondary" style="margin-left:2%;margin-top:3%;float:right;">Resetta</button>
  
                        </form>
                  </div>                 
                </div>
              </div>
               
      </div>

      <div class="col-md-11" style="display:block !important;margin-right:auto !important; margin-left:auto !important; margin-top:3%;background-color:white;border-radius:10px;">
        <div class="table-responsive-nomarginpadding">
              <table id="myDatatable" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="display:none;">#</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Year</th>           
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                  <th style="display:none;">#</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Year</th>                          
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ( $result as $art_id=>$value ) {?>
                  <tr>
                      <td style="display:none;"><?= $value['art_id'] ?></td>
                      <td><?=  $value['art_author']  ?></td>
                      <td  class="focus"><a href="<?= $value['art_link'] ?>"> <?= $value['art_title'] ?></a></td>          
                      <td><?=  $value['art_year']  ?></td> 
                  <?php }?>
                </tbody>
              </table>
        </div>
          <div class="row" style="height:40px;"></div> 
      </div>    
</div>   
<!-- FOOTER -->
</main>
<?php require_once( ROOT_PATH . '/includes/footer.php') ?>
</body>
</html>   