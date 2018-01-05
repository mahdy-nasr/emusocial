<ul class="list-group">
  <li class="list-group-item"><i class="fa fa-user text-primary"></i>&nbsp; <?=ucwords($profile->getFullName())?></li>
  <li class="list-group-item"><i class="fa fa-mobile text-primary"></i>&nbsp; <?=$profile->getIdentification()?></li>
    <li class="list-group-item"><i class="fa fa-id-card-o text-primary"></i>&nbsp; <?=$profile->getIdentification()?></li>

  <li class="list-group-item"><i class="fa fa-university text-primary"></i>&nbsp; Department: <?=$profile->getDepartmentName()?></li>
  <li class="list-group-item"><i class="fa fa-transgender text-primary"></i>&nbsp; Gender: <?=ucfirst($profile->getGender())?></li>
  <li class="list-group-item"><i class="fa fa-users  text-primary"></i>&nbsp; Role <?=$profile->getUserType()?></li>

 
  <?php if(strlen($profile->getDateOfBirth())>3):?>
      <li class="list-group-item"><i class="fa fa-calendar text-primary"></i>&nbsp; Born on <?=$profile->getDateOfBirth()?></li>
  <?php endif;?>
   <?php if($profile->getEmail()):?>
      <li class="list-group-item"><i class="fa fa-envelope text-primary"></i>&nbsp; Born on <?=$profile->getEmail()?></li>
  <?php endif;?>

                
                
  <!--li class="list-group-item"><i class="fa fa-tags text-primary"></i>&nbsp; 
    <label class="label label-info">Html 5</label> 
    <label class="label label-primary">Css 3</label> 
    <label class="label label-warning">Boostrap</label> 
    <label class="label label-success">Jquery</label> 
  </li-->
</ul>