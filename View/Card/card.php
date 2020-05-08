   <div class="container">
     <div class="row justify-content-center">
       <div class="col">
         <div class="row">
           <div class="col-md-12 col-lg-12">
             <div class="card card-body <?= $this->clean($card['stylename']) ?> text-light">
               <div class="d-flex justify-content-between mb-3">
                 <div class="text-small d-flex">
                   <h1 class="ml-3 text-black"><?= $this->clean($card['title']) ?></h1><br>
                 </div>
               </div>
               <div class="d-flex">
                 <div class="ml-3">
                   <span class="h4 opacity-70">//&nbsp;<?= $this->clean($card['definition']); ?></span>
                   <p></p>
                   <h6 class="mb-1"><?= $card['content']; ?></h6>
                   <span class="opacity-70">|&nbsp;<?= $this->clean($card['date_creation_fr']) ?>&nbsp;|&nbsp;par <a href="<?= "user/profile/" . $this->clean($card['id_user']) ?>" title="<?= $this->clean($card['firstname']) . '&nbsp;' . $this->clean($card['name'])?>"><?= $this->clean($card['firstname']) . '&nbsp;' . $this->clean($card['name'])?></a></span>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
   <div class="pr-lg-4 ml-3"><!-- Commentaires  -->
